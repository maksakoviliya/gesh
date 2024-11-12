<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transfer\RegularDriveResource;
use App\Models\Transfer\RegularDrive;
use Inertia\Inertia;
use Inertia\Response;

final class TransferRegularRideViewController extends Controller
{
    public function __invoke(RegularDrive $drive): Response
    {
        return Inertia::render(
            component: 'Transfer/RegularDrive/RegularDriveView',
            props: [
                'drive' => new RegularDriveResource($drive),
            ]
        );
    }
}
