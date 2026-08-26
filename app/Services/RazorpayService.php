<?php

namespace App\Services;

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use RuntimeException;

class RazorpayService
{
    private Api $api;

    public function __construct()
    {
        $this->registerFallbackAutoloaders();

        $keyId = (string) config('services.razorpay.key_id');
        $keySecret = (string) config('services.razorpay.key_secret');

        if ($keyId === '' || $keySecret === '') {
            throw new RuntimeException('Razorpay credentials are not configured.');
        }

        $this->api = new Api($keyId, $keySecret);
    }

    private function registerFallbackAutoloaders(): void
    {
        if (! class_exists(Api::class)) {
            $base = base_path('vendor/razorpay/razorpay/src/');
            spl_autoload_register(function (string $class) use ($base): void {
                $prefix = 'Razorpay\\Api\\';

                if (! str_starts_with($class, $prefix)) {
                    return;
                }

                $file = $base.str_replace('\\', '/', substr($class, strlen($prefix))).'.php';

                if (is_file($file)) {
                    require_once $file;
                }
            });
        }

        if (! class_exists('WpOrg\\Requests\\Requests')) {
            $requestsBase = base_path('vendor/rmccue/requests/');

            if (is_file($requestsBase.'library/Deprecated.php')) {
                require_once $requestsBase.'library/Deprecated.php';
            }

            if (is_file($requestsBase.'library/Requests.php')) {
                require_once $requestsBase.'library/Requests.php';
            }

            spl_autoload_register(function (string $class) use ($requestsBase): void {
                $prefix = 'WpOrg\\Requests\\';

                if (! str_starts_with($class, $prefix)) {
                    return;
                }

                $file = $requestsBase.'src/'.str_replace('\\', '/', substr($class, strlen($prefix))).'.php';

                if (is_file($file)) {
                    require_once $file;
                }
            });
        }
    }

    public function createOrder(int $amountPaise, string $currency, string $receipt, array $notes = []): array
    {
        return $this->api->order->create([
            'amount' => $amountPaise,
            'currency' => $currency,
            'receipt' => $receipt,
            'notes' => $notes,
        ])->toArray();
    }

    public function fetchPayment(string $paymentId): array
    {
        return $this->api->payment->fetch($paymentId)->toArray();
    }

    public function fetchOrder(string $orderId): array
    {
        return $this->api->order->fetch($orderId)->toArray();
    }

    public function verifyPaymentSignature(string $orderId, string $paymentId, string $signature): bool
    {
        try {
            $this->api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
            ]);

            return true;
        } catch (SignatureVerificationError) {
            return false;
        }
    }

    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $secret = (string) config('services.razorpay.webhook_secret');

        if ($secret === '') {
            throw new RuntimeException('Razorpay webhook secret is not configured.');
        }

        try {
            $this->api->utility->verifyWebhookSignature($payload, $signature, $secret);

            return true;
        } catch (SignatureVerificationError) {
            return false;
        }
    }

    public function amountToPaise(float|string $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }
}
