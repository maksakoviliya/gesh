<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;

class TestContreoller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $collection = Apartment::query()
            ->whereNotNull('created_at')
            ->get();
        return Apartment::export($collection);
    }
}
