<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use App\Models\Payment;
use App\Services\RazorpayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Throwable;

class RazorpayPaymentController extends Controller
{
    private const CURRENCY = 'INR';

    private const COMPANY_PLANS = [
        'basic' => ['amount' => 2, 'credits' => 500],
        'premium' => ['amount' => 3, 'credits' => 2500],
        'enterprise' => ['amount' => 4, 'credits' => 5000],
    ];

    private const DIRECT_MODE_PLANS = [
        'basic' => ['amount' => 3, 'credits' => 1000, 'validity_days' => 60],
        'pro' => ['amount' => 4, 'credits' => 2500, 'validity_days' => 90],
        'premium' => ['amount' => 5, 'credits' => 5000, 'validity_days' => 120],
        'ultimate' => ['amount' => 1499, 'credits' => 10000, 'validity_days' => 180],
    ];

    public function createOrder(Request $request, RazorpayService $razorpay): JsonResponse
    {
        $validated = $request->validate([
            'purpose' => ['required', Rule::in(['course_enrollment', 'company_subscription', 'direct_mode_subscription'])],
            'course_enrollment_id' => ['required_if:purpose,course_enrollment', 'integer', 'exists:course_enrollments,id'],
            'plan' => ['required_unless:purpose,course_enrollment', 'string'],
        ]);

        $user = $request->user();
        [$amount, $description, $metadata] = $this->resolvePayable($user, $validated);
        $amountPaise = $razorpay->amountToPaise($amount);

        if ($amountPaise <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid payment amount.',
            ], 422);
        }

        try {
            $payment = DB::transaction(function () use ($user, $validated, $amount, $metadata, $razorpay, $amountPaise, $description) {
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'course_enrollment_id' => $metadata['course_enrollment_id'] ?? null,
                    'purpose' => $validated['purpose'],
                    'plan' => $validated['plan'] ?? null,
                    'amount' => $amount,
                    'currency' => self::CURRENCY,
                    'payment_status' => 'pending',
                    'metadata' => $metadata,
                ]);

                $order = $razorpay->createOrder(
                    $amountPaise,
                    self::CURRENCY,
                    'ofc_payment_'.$payment->id,
                    [
                        'payment_id' => (string) $payment->id,
                        'purpose' => $validated['purpose'],
                    ]
                );

                $payment->update([
                    'razorpay_order_id' => $order['id'],
                    'metadata' => array_merge($metadata, [
                        'razorpay_order' => [
                            'id' => $order['id'],
                            'amount' => $order['amount'] ?? $amountPaise,
                            'currency' => $order['currency'] ?? self::CURRENCY,
                        ],
                        'description' => $description,
                    ]),
                ]);

                return $payment->fresh();
            });
        } catch (Throwable $exception) {
            Log::error('Razorpay order creation failure', [
                'user_id' => $user->id,
                'purpose' => $validated['purpose'],
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment order could not be created. Please try again.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Razorpay order created successfully.',
            'data' => [
                'key' => config('services.razorpay.key_id'),
                'razorpay_order_id' => $payment->razorpay_order_id,
                'amount' => $amountPaise,
                'currency' => self::CURRENCY,
                'name' => config('app.name', 'OnlyFreshers'),
                'description' => $description,
                'prefill' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'contact' => $user->mobile,
                ],
            ],
        ]);
    }

    public function verify(Request $request, RazorpayService $razorpay): JsonResponse
    {
        $validated = $request->validate([
            'razorpay_payment_id' => ['required', 'string', 'max:255'],
            'razorpay_order_id' => ['required', 'string', 'max:255'],
            'razorpay_signature' => ['required', 'string', 'max:255'],
        ]);

        if (! $razorpay->verifyPaymentSignature($validated['razorpay_order_id'], $validated['razorpay_payment_id'], $validated['razorpay_signature'])) {
            Log::warning('Razorpay signature verification failure', [
                'order_id' => $validated['razorpay_order_id'],
                'user_id' => $request->user()->id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
            ], 422);
        }

        try {
            $razorpayPayment = $razorpay->fetchPayment($validated['razorpay_payment_id']);
            $payment = DB::transaction(function () use ($request, $validated, $razorpayPayment, $razorpay) {
                $payment = Payment::query()
                    ->where('razorpay_order_id', $validated['razorpay_order_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ((int) $payment->user_id !== (int) $request->user()->id) {
                    abort(403, 'This payment does not belong to your account.');
                }

                if ($payment->payment_status === 'success') {
                    return $payment->fresh();
                }

                $expectedAmount = $razorpay->amountToPaise($payment->amount);
                $actualAmount = (int) ($razorpayPayment['amount'] ?? 0);
                $actualCurrency = (string) ($razorpayPayment['currency'] ?? '');
                $actualOrderId = (string) ($razorpayPayment['order_id'] ?? '');
                $actualStatus = (string) ($razorpayPayment['status'] ?? '');

                if ($actualOrderId !== $payment->razorpay_order_id || $actualAmount !== $expectedAmount || $actualCurrency !== $payment->currency) {
                    Log::warning('Razorpay payment amount/order mismatch', [
                        'payment_id' => $payment->id,
                        'expected_amount' => $expectedAmount,
                        'actual_amount' => $actualAmount,
                        'expected_order' => $payment->razorpay_order_id,
                        'actual_order' => $actualOrderId,
                    ]);

                    abort(422, 'Payment details do not match the order.');
                }

                if (! in_array($actualStatus, ['authorized', 'captured'], true)) {
                    abort(422, 'Payment is not completed yet.');
                }

                $payment->update([
                    'transaction_id' => $validated['razorpay_payment_id'],
                    'razorpay_payment_id' => $validated['razorpay_payment_id'],
                    'razorpay_signature' => $validated['razorpay_signature'],
                    'payment_status' => 'success',
                    'payment_method' => $razorpayPayment['method'] ?? null,
                    'payment_date' => now(),
                    'paid_at' => now(),
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'razorpay_payment' => [
                            'id' => $razorpayPayment['id'] ?? null,
                            'status' => $actualStatus,
                            'amount' => $actualAmount,
                            'currency' => $actualCurrency,
                            'method' => $razorpayPayment['method'] ?? null,
                        ],
                    ]),
                ]);

                $this->completeBusinessAction($payment->fresh());

                return $payment->fresh();
            });
        } catch (Throwable $exception) {
            Log::error('Razorpay payment verification failure', [
                'order_id' => $validated['razorpay_order_id'],
                'user_id' => $request->user()->id,
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage() ?: 'Payment could not be verified.',
            ], $exception->getCode() >= 400 && $exception->getCode() < 500 ? $exception->getCode() : 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment verified successfully.',
            'data' => [
                'payment' => $payment,
                'redirect_to' => $this->redirectFor($payment),
            ],
        ]);
    }

    private function resolvePayable($user, array $validated): array
    {
        if ($validated['purpose'] === 'course_enrollment') {
            $enrollment = CourseEnrollment::query()
                ->with('course')
                ->whereKey($validated['course_enrollment_id'])
                ->firstOrFail();

            if ($user->role !== 'fresher' || ! $user->fresherProfile || $enrollment->fresher_profile_id !== $user->fresherProfile->id) {
                abort(403, 'You are not authorized to pay for this enrollment.');
            }

            if ($enrollment->payment_status === 'paid') {
                abort(422, 'Payment has already been completed for this enrollment.');
            }

            if ($enrollment->enrollment_status === 'cancelled') {
                abort(422, 'Payment cannot be made for a cancelled enrollment.');
            }

            return [
                (float) $enrollment->course->fees,
                'Fast Track course payment: '.$enrollment->course->course_name,
                ['course_enrollment_id' => $enrollment->id, 'course_id' => $enrollment->course_id],
            ];
        }

        if ($validated['purpose'] === 'company_subscription') {
            if ($user->role !== 'company' || ! $user->companyProfile) {
                abort(403, 'Only companies can purchase hiring plans.');
            }

            $plan = $validated['plan'];
            abort_unless(isset(self::COMPANY_PLANS[$plan]), 422, 'Invalid company subscription plan.');

            return [
                self::COMPANY_PLANS[$plan]['amount'],
                'Company hiring credits: '.$plan,
                ['credits' => self::COMPANY_PLANS[$plan]['credits']],
            ];
        }

        if ($user->role !== 'fresher' || ! $user->fresherProfile) {
            abort(403, 'Only freshers can purchase Direct Mode plans.');
        }

        $plan = $validated['plan'];
        abort_unless(isset(self::DIRECT_MODE_PLANS[$plan]), 422, 'Invalid Direct Mode subscription plan.');

        return [
            self::DIRECT_MODE_PLANS[$plan]['amount'],
            'Direct Mode application credits: '.$plan,
            [
                'credits' => self::DIRECT_MODE_PLANS[$plan]['credits'],
                'validity_days' => self::DIRECT_MODE_PLANS[$plan]['validity_days'],
            ],
        ];
    }

    private function completeBusinessAction(Payment $payment): void
    {
        if ($payment->purpose === 'course_enrollment' && $payment->courseEnrollment) {
            $payment->courseEnrollment->update([
                'payment_status' => 'paid',
                'enrollment_status' => 'enrolled',
                'training_status' => 'not_started',
            ]);
        }

        if ($payment->purpose === 'company_subscription' && $payment->user?->companyProfile) {
            $payment->user->companyProfile->increment('job_credits', (int) ($payment->metadata['credits'] ?? 0));
            $payment->user->companyProfile->update([
                'subscription_plan' => $payment->plan,
                'subscribed_at' => now(),
            ]);
        }

        if ($payment->purpose === 'direct_mode_subscription' && $payment->user?->fresherProfile) {
            $validityDays = (int) ($payment->metadata['validity_days'] ?? 0);
            $expiresAt = $validityDays > 0 ? now()->addDays($validityDays) : null;

            $payment->user->fresherProfile->increment('direct_mode_credits', (int) ($payment->metadata['credits'] ?? 0));
            $payment->user->fresherProfile->update([
                'direct_mode_subscription_plan' => $payment->plan,
                'direct_mode_subscribed_at' => now(),
                'direct_mode_subscription_expires_at' => $expiresAt,
            ]);
        }
    }

    private function redirectFor(Payment $payment): string
    {
        return match ($payment->purpose) {
            'course_enrollment' => '/fast-track/training',
            'company_subscription' => '/company/post-job',
            'direct_mode_subscription' => '/direct-mode/dashboard#credits',
            default => '/',
        };
    }
}
