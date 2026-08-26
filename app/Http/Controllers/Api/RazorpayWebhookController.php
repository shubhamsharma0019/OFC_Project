<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\RazorpayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class RazorpayWebhookController extends Controller
{
    public function handle(Request $request, RazorpayService $razorpay): JsonResponse
    {
        $payload = $request->getContent();
        $signature = (string) $request->header('X-Razorpay-Signature');

        if ($signature === '' || ! $razorpay->verifyWebhookSignature($payload, $signature)) {
            Log::warning('Razorpay webhook signature failure');

            return response()->json(['success' => false], 400);
        }

        $event = json_decode($payload, true);
        if (! is_array($event)) {
            return response()->json(['success' => false], 400);
        }

        $eventId = (string) ($event['id'] ?? hash('sha256', $payload));
        $eventName = (string) ($event['event'] ?? 'unknown');

        try {
            DB::transaction(function () use ($eventId, $eventName, $event) {
                $inserted = DB::table('razorpay_webhook_events')->insertOrIgnore([
                    'event_id' => $eventId,
                    'event_name' => $eventName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($inserted === 0) {
                    Log::info('Duplicate Razorpay webhook ignored', ['event_id' => $eventId]);
                    return;
                }

                $paymentEntity = $event['payload']['payment']['entity'] ?? null;
                if (! is_array($paymentEntity)) {
                    return;
                }

                $orderId = $paymentEntity['order_id'] ?? null;
                if (! $orderId) {
                    return;
                }

                $payment = Payment::query()
                    ->where('razorpay_order_id', $orderId)
                    ->lockForUpdate()
                    ->first();

                if (! $payment) {
                    Log::warning('Unknown Razorpay webhook order', ['order_id' => $orderId, 'event' => $eventName]);
                    return;
                }

                if ($eventName === 'payment.failed') {
                    $payment->update([
                        'payment_status' => 'failed',
                        'razorpay_payment_id' => $paymentEntity['id'] ?? $payment->razorpay_payment_id,
                        'failure_reason' => $paymentEntity['error_description'] ?? $paymentEntity['error_reason'] ?? 'Payment failed.',
                        'metadata' => array_merge($payment->metadata ?? [], ['last_webhook_event' => $eventName]),
                    ]);
                }

                if (in_array($eventName, ['payment.authorized', 'payment.captured', 'order.paid'], true)) {
                    $payment->update([
                        'metadata' => array_merge($payment->metadata ?? [], ['last_webhook_event' => $eventName]),
                    ]);
                }
            });
        } catch (Throwable $exception) {
            Log::error('Razorpay webhook processing failure', [
                'event' => $eventName,
                'error' => $exception->getMessage(),
            ]);

            return response()->json(['success' => false], 500);
        }

        return response()->json(['success' => true]);
    }
}
