<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transfer\RegularDrive\ShortRegularDriveResource;
use App\Models\Transfer\RegularDrive;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class TransferIndexController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $regularDrives = ShortRegularDriveResource::collection(
            RegularDrive::query()
                ->with('media')
                ->select(['id', 'name', 'status', 'regular_price'])
                ->active()
                ->get()
        );

        return Inertia::render('Transfer/Index', compact('regularDrives'));
    }
}
