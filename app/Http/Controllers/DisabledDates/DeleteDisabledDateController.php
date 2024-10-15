<?php

declare(strict_types=1);

namespace App\Http\Controllers\DisabledDates;

use App\Http\Controllers\Controller;
use App\Models\DisabledDate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class DeleteDisabledDateController extends Controller
{
    public function __invoke(Request $request, DisabledDate $disabledDate): JsonResponse
    {
        $disabledDate->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
