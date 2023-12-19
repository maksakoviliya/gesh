<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Apartments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Apartments\DeleteRequest;
use App\Models\Apartment;

final class DeleteController extends Controller
{
    public function __invoke(DeleteRequest $request, Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->back()->with('info', 'Объект успешно удален.');
    }
}
