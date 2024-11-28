<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Apartment;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

final class ApartmentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(public Collection $collection) {}

    public function collection(): Collection
    {
        return Apartment::query()
            ->whereIn(
                column: 'id',
                values: $this->collection->pluck('id')
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Владелец',
            'Владелец, email',
            'Владелец, телефон',
            'Статус',
            'Категория',
            'Тип',
            'Город',
            'Улица',
            'Дом',
            'Коррпус',
            'Квартира',
            'Этаж',
            'Подъезд',
            'Индекс',
            'Координаты, lon',
            'Координаты, lat',
            'Гости',
            'Спальни',
            'Кровати',
            'Ванные',
            'Название',
            'Описание',
            'Цена в будни, руб.',
            'Цена в выходные, руб.',
            'Мгновенное бронирование',
            'Дата добавления',
        ];
    }

    /**
     * @param  Apartment  $row
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->user->name,
            $row->user->email,
            $row->user->phone,
            $row->status->value,
            $row->category->title,
            $row->type->value,
            $row->city,
            $row->street,
            $row->building,
            $row->housing,
            $row->room,
            $row->floor,
            $row->entrance,
            $row->index,
            $row->lon,
            $row->lat,
            $row->guests,
            $row->bedrooms,
            $row->beds,
            $row->bathrooms,
            $row->title,
            $row->description,
            $row->weekdays_price,
            $row->weekends_price,
            $row->fast_reserve ? 'Да' : 'Нет',
            Date::dateTimeToExcel($row->created_at),
        ];
    }
}
