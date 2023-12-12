<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Apartment;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\WithMapping;
//use PhpOffice\PhpSpreadsheet\Shared\Date;

final class ApartmentsExport implements FromCollection
//    , WithHeadings
//    , WithMapping
{
    public function __construct(public Collection $collection)
    {
    }

    public function collection(): Collection
    {
        return Apartment::all();
    }

//    public function headings(): array
//    {
//        return ['id'];
//    }

//    /**
//     * @param Apartment $apartment
//     * @return array
//     */
//    public function map($apartment): array
//    {
//        return [
//            $apartment->id,
//            $apartment->user->name,
//            Date::dateTimeToExcel($apartment->created_at),
//        ];
//    }
}
