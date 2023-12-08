<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;

interface PaymentServiceContract
{
    public function getClient();

    public function createPayment(int $amount, string $return_url, string $description);

    public function callback(Request $request);
}
