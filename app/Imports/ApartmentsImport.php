<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\Apartments\Status;
use App\Models\Apartment;
use Maatwebsite\Excel\Concerns\ToModel;

final class ApartmentsImport implements ToModel
{
    public function model(array $row)
    {
        return new Apartment([
            'status' => Status::Draft,

        ]);
    }
}
