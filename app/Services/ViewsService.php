<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Apartment;

class ViewsService
{
    public function incrementViews(Apartment $apartment): void
    {
        $apartment->update([
            'views' => $apartment->views + 1
        ]);
    }
}