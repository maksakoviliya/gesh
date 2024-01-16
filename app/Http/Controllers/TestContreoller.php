<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Reservation\Status;
use App\Models\Reservation;
use Illuminate\Http\Request;

final class TestContreoller extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [
            'id' => '01hm906tt0s116f7b8bnxst8ea',
            'date' => '16 января 2024',
            'quantity' => 1,
            'description' => '1 Year Subscription',
            'price' => '129.00'
        ];
        return view('pdfs.voucher', compact('data'));
    }
}
