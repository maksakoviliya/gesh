<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use YooKassa\Client;

class YooKassaPaymentService implements PaymentServiceContract
{
    public function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret'));

        return $client;
    }

    public function createPayment(int $amount, string $return_url, Reservation $reservation)
    {
        //        try {
        $client = $this->getClient();
        $payment = $client->createPayment(
            [
                'amount' => [
                    'value' => $amount,
                    'currency' => 'RUB',
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => $return_url,
                ],
                'capture' => true,
                'description' => $reservation->getPaymentDescription(),
                'metadata' => [
                    'reservation_id' => $reservation->id
                ]
            ],
            uniqid('', true)
        );

        return $payment->getConfirmation()->getConfirmationUrl();
        //        } catch (\Throwable $exception) {
        //            Log::error($exception->getMessage());
        //        }
    }

    public function callback(Request $request)
    {
        // TODO: Implement callback() method.
    }
}
