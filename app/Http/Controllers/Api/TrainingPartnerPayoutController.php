<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\TrainingPartnerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingPartnerPayoutController extends Controller
{
    private const PLATFORM_FEE_PERCENT = 10;

    public function index(Request $request): JsonResponse
    {
        $trainingPartnerProfile = $this->getApprovedTrainingPartnerProfile($request);

        if (!$trainingPartnerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Only approved training partners can access payouts.',
            ], 403);
        }

        $paymentQuery = Payment::query()
            ->whereHas('courseEnrollment.course', function ($query) use ($trainingPartnerProfile) {
                $query->where('training_partner_profile_id', $trainingPartnerProfile->id);
            });

        $successfulAmount = (float) (clone $paymentQuery)
            ->where('payment_status', 'success')
            ->sum('amount');

        $platformFee = round($successfulAmount * self::PLATFORM_FEE_PERCENT / 100, 2);
        $netPayout = round($successfulAmount - $platformFee, 2);

        $monthlyPayouts = (clone $paymentQuery)
            ->selectRaw('DATE_FORMAT(payment_date, "%Y-%m") as month, SUM(amount) as gross_amount, COUNT(*) as payments')
            ->where('payment_status', 'success')
            ->whereNotNull('payment_date')
            ->groupBy(DB::raw('DATE_FORMAT(payment_date, "%Y-%m")'))
            ->orderByDesc('month')
            ->limit(12)
            ->get()
            ->map(function ($row) {
                $gross = (float) $row->gross_amount;
                $fee = round($gross * self::PLATFORM_FEE_PERCENT / 100, 2);
                $row->platform_fee = $fee;
                $row->net_amount = round($gross - $fee, 2);
                $row->status = 'available';

                return $row;
            });

        $payments = (clone $paymentQuery)
            ->with([
                'courseEnrollment.course',
                'courseEnrollment.fresherProfile.user',
            ])
            ->latest('payment_date')
            ->limit(30)
            ->get()
            ->map(function (Payment $payment) {
                $gross = (float) $payment->amount;
                $fee = $payment->payment_status === 'success'
                    ? round($gross * self::PLATFORM_FEE_PERCENT / 100, 2)
                    : 0;

                $payment->platform_fee = $fee;
                $payment->net_amount = $payment->payment_status === 'success'
                    ? round($gross - $fee, 2)
                    : 0;

                return $payment;
            });

        return response()->json([
            'success' => true,
            'message' => 'Payouts fetched successfully.',
            'data' => [
                'summary' => [
                    'gross_earnings' => $successfulAmount,
                    'platform_fee' => $platformFee,
                    'net_payout' => $netPayout,
                    'successful_payments' => (clone $paymentQuery)->where('payment_status', 'success')->count(),
                    'pending_payments' => (clone $paymentQuery)->where('payment_status', 'pending')->count(),
                    'failed_payments' => (clone $paymentQuery)->where('payment_status', 'failed')->count(),
                    'platform_fee_percent' => self::PLATFORM_FEE_PERCENT,
                ],
                'monthly_payouts' => $monthlyPayouts,
                'payments' => $payments,
            ],
        ]);
    }

    private function getApprovedTrainingPartnerProfile(Request $request): ?TrainingPartnerProfile
    {
        $user = $request->user();

        if (!$user || $user->role !== 'training_partner') {
            return null;
        }

        return TrainingPartnerProfile::query()
            ->where('user_id', $user->id)
            ->where('approval_status', 'approved')
            ->first();
    }
}
