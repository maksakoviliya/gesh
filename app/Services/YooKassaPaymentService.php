<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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

    public function createPayment(int $amount, array $additionalParameters = null)
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
                        'return_url' => route('account.reservations.view', [
                            'reservation' => Arr::get($additionalParameters, 'reservation_id'),
                        ]),
                    ],
                    'capture' => true,
                    'description' => Arr::get($additionalParameters, 'reservation_id'),
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
