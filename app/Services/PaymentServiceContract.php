<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;

interface PaymentServiceContract
{
    public function getClient();

    public function createPayment(int $amount, array $additionalParameters = null);

    public function callback(Request $request);
}
