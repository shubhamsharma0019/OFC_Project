<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use App\Models\Notification;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FresherCoursePaymentController extends Controller
{
    /**
     * Mock/manual course payment save karega.
     */
    public function pay(
        Request $request,
        CourseEnrollment $courseEnrollment
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can make course payments.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        if (
            $courseEnrollment->fresher_profile_id
            !== $fresherProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to pay for this enrollment.',
            ], 403);
        }

        if ($courseEnrollment->enrollment_status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Payment cannot be made for a cancelled enrollment.',
            ], 422);
        }

        if ($courseEnrollment->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Payment has already been completed for this enrollment.',
            ], 422);
        }

        $courseEnrollment->load('course.trainingPartnerProfile');

        if (!$courseEnrollment->course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found for this enrollment.',
            ], 404);
        }

        $validated = $request->validate([
            'transaction_id' => [
                'required',
                'string',
                'max:255',
                'unique:payments,transaction_id',
            ],

            'payment_status' => [
                'required',
                'string',
                Rule::in([
                    'success',
                    'failed',
                ]),
            ],
        ]);

        $result = DB::transaction(function () use (
            $validated,
            $courseEnrollment
        ) {
            $payment = Payment::create([
                'course_enrollment_id' => $courseEnrollment->id,
                'amount' => $courseEnrollment->course->fees,
                'transaction_id' => $validated['transaction_id'],
                'payment_status' => $validated['payment_status'],
                'payment_date' => now(),
            ]);

            if ($validated['payment_status'] === 'success') {
                $courseEnrollment->update([
                    'payment_status' => 'paid',
                    'enrollment_status' => 'enrolled',
                    'training_status' => 'not_started',
                ]);
            } else {
                $courseEnrollment->update([
                    'payment_status' => 'failed',
                    'enrollment_status' => 'pending',
                ]);
            }

            return [
                'payment' => $payment,
                'enrollment' => $courseEnrollment->fresh(),
            ];
        });

        $message = $validated['payment_status'] === 'success'
            ? 'Course payment completed successfully.'
            : 'Course payment failed.';

        $freshEnrollment = $result['enrollment']->loadMissing('course.trainingPartnerProfile');
        if ($validated['payment_status'] === 'success') {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'course_payment',
                'title' => 'Payment Successful',
                'message' => "Your payment for {$freshEnrollment->course->course_name} is successful. Training can now start.",
                'is_read' => false,
            ]);

            if ($freshEnrollment->course?->trainingPartnerProfile?->user_id) {
                Notification::create([
                    'user_id' => $freshEnrollment->course->trainingPartnerProfile->user_id,
                    'type' => 'course_payment',
                    'title' => 'Course Payment Received',
                    'message' => ($user->name ?? 'A fresher') . " completed payment for {$freshEnrollment->course->course_name}.",
                    'is_read' => false,
                ]);
            }
        }

        return response()->json([
            'success' => $validated['payment_status'] === 'success',
            'message' => $message,
            'data' => $result,
        ], $validated['payment_status'] === 'success' ? 201 : 200);
    }

    /**
     * Selected enrollment ke saare payment attempts fetch karega.
     */
    public function index(
        Request $request,
        CourseEnrollment $courseEnrollment
    ): JsonResponse {
        $user = $request->user();

        if ($user->role !== 'fresher') {
            return response()->json([
                'success' => false,
                'message' => 'Only freshers can access course payments.',
            ], 403);
        }

        $fresherProfile = $user->fresherProfile;

        if (!$fresherProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Fresher profile not found.',
            ], 404);
        }

        if (
            $courseEnrollment->fresher_profile_id
            !== $fresherProfile->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view these payments.',
            ], 403);
        }

        $payments = Payment::query()
            ->where(
                'course_enrollment_id',
                $courseEnrollment->id
            )
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Course payments fetched successfully.',
            'data' => [
                'enrollment' => $courseEnrollment,
                'payments' => $payments,
            ],
        ]);
    }
}
