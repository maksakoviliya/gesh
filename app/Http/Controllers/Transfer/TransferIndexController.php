<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class TransferIndexController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Transfer/Index');
    }
}
