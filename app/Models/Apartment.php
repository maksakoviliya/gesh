<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Apartments\Status;
use App\Enums\Apartments\Type;
use App\Exports\ApartmentsExport;
use App\Imports\ApartmentsImport;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Database\Factories\ApartmentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * App\Models\Apartment
 *
 * @property string $id
 * @property Status $status
 * @property int $step
 * @property string $user_id
 * @property int|null $category_id
 * @property Type|null $type
 * @property string|null $country_code
 * @property string|null $state
 * @property string|null $city
 * @property string|null $street
 * @property string|null $building
 * @property string|null $housing
 * @property string|null $room
 * @property string|null $floor
 * @property string|null $entrance
 * @property string|null $index
 * @property string|null $lon
 * @property string|null $lat
 * @property int|null $guests
 * @property int|null $bedrooms
 * @property int|null $beds
 * @property int|null $bathrooms
 * @property string|null $title
 * @property string|null $description
 * @property int|null $weekdays_price
 * @property int|null $weekends_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool|null $fast_reserve
 * @property-read Category|null $category
 * @property-read Collection<int, DatePrice> $datePrices
 * @property-read int|null $date_prices_count
 * @property-read Collection<int, Feature> $features
 * @property-read int|null $features_count
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read User|null $user
 * @method static ApartmentFactory factory($count = null, $state = [])
 * @method static Builder|Apartment filter(Request $request)
 * @method static Builder|Apartment newModelQuery()
 * @method static Builder|Apartment newQuery()
 * @method static Builder|Apartment published()
 * @method static Builder|Apartment query()
 * @method static Builder|Apartment whereBathrooms($value)
 * @method static Builder|Apartment whereBedrooms($value)
 * @method static Builder|Apartment whereBeds($value)
 * @method static Builder|Apartment whereBuilding($value)
 * @method static Builder|Apartment whereCategoryId($value)
 * @method static Builder|Apartment whereCity($value)
 * @method static Builder|Apartment whereCountryCode($value)
 * @method static Builder|Apartment whereCreatedAt($value)
 * @method static Builder|Apartment whereDescription($value)
 * @method static Builder|Apartment whereEntrance($value)
 * @method static Builder|Apartment whereFastReserve($value)
 * @method static Builder|Apartment whereFloor($value)
 * @method static Builder|Apartment whereGuests($value)
 * @method static Builder|Apartment whereHousing($value)
 * @method static Builder|Apartment whereId($value)
 * @method static Builder|Apartment whereIndex($value)
 * @method static Builder|Apartment whereLat($value)
 * @method static Builder|Apartment whereLon($value)
 * @method static Builder|Apartment whereRoom($value)
 * @method static Builder|Apartment whereState($value)
 * @method static Builder|Apartment whereStatus($value)
 * @method static Builder|Apartment whereStep($value)
 * @method static Builder|Apartment whereStreet($value)
 * @method static Builder|Apartment whereTitle($value)
 * @method static Builder|Apartment whereType($value)
 * @method static Builder|Apartment whereUpdatedAt($value)
 * @method static Builder|Apartment whereUserId($value)
 * @method static Builder|Apartment whereWeekdaysPrice($value)
 * @method static Builder|Apartment whereWeekendsPrice($value)
 * @property-read Collection<int, ICalLink> $ICalLinks
 * @property-read int|null $i_cal_links_count
 * @property-read Collection<int, DisabledDate> $disabledDates
 * @property-read int|null $disabled_dates_count
 * @property-read Collection<int, Reservation> $reservations
 * @property-read int|null $reservations_count
 * @property-read Collection<int, SideReservation> $sideReservations
 * @property-read int|null $side_reservations_count
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|Apartment onlyTrashed()
 * @method static Builder|Apartment whereDeletedAt($value)
 * @method static Builder|Apartment withTrashed()
 * @method static Builder|Apartment withoutTrashed()
 * @method static Builder|Apartment order()
 * @mixin Eloquent
 */
final class Apartment extends Model implements HasMedia
{
    use HasFactory, HasUlids, InteractsWithMedia, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $with = [
        'media',
    ];

    protected $casts = [
        'status' => Status::class,
        'type' => Type::class,
        'fast_reserve' => 'boolean',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('responsive')
            ->performOnCollections('default')
            ->withResponsiveImages();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        if ($category_slug = $request->get('category')) {
            $category = Category::query()
                ->where('slug', $category_slug)
                ->first();
            $query->where('category_id', $category->id);
        }
        if ($city = $request->get('city')) {
            $query->where('city', 'like', "%$city%");
        }
        if ($guests = $request->get('guests')) {
            $query->where('guests', '>=', $guests);
        }
        if ($request->has('start') && $request->has('end')) {
            $start = Carbon::createFromFormat('d_m_Y', $request->get('start'), 'Europe/Moscow')->setTime(15, 00);
            $end = Carbon::createFromFormat('d_m_Y', $request->get('end'), 'Europe/Moscow')->setTime(12, 00);

            //            $apart = Apartment::find('01hhes40frzneyjrdr8jvyrne9');
            //
            //            $sr = SideReservation::query()
            //                ->where('apartment_id', $apart->id)
            //                            ->where(function ($subQuery) use ($start, $end) {
            //                $subQuery->whereDate('start', '<=', $start)
            //                    ->whereDate('end', '>=', $end)
            ////                    ->whereDate('end', '>=', $start)
            //                ;
            //            })

            //            $query->where(function ($subQuery) use ($start, $end) {
            //                $subQuery->whereDate('start', '>=', $start)
            //                    ->whereDate('end', '<=', $end);
            //            })
            //                ->orWhere(function ($subQuery) use ($start, $end) {
            //                    $subQuery
            //                        ->whereDate('start', '>=', $start)
            //                        ->whereDate('start', '<', $end)
            //                        ->whereDate('end', '>', $end);
            //                })
            //                ->orWhere(function ($subQuery) use ($start, $end) {
            //                    $subQuery
            //                        ->whereDate('start', '<', $start)
            //                        ->whereDate('end', '>', $start)
            //                        ->whereDate('end', '<=', $end);
            //                })
            //            ->get();

            $query
                ->whereDoesntHave('disabledDates', function (Builder $q) use ($start, $end) {
                    $q->whereDate('date', '>', $start)
                        ->whereDate('date', '<', $end);
                })
                ->whereDoesntHave('reservations', function (Builder $q) use ($start, $end) {
                    $q->where(function ($subQuery) use ($start, $end) {
                        $subQuery->whereDate('start', '>=', $start)
                            ->whereDate('end', '<=', $end);
                    })
                        ->orWhere(function ($subQuery) use ($start, $end) {
                            $subQuery
                                ->whereDate('start', '>=', $start)
                                ->whereDate('start', '<', $end)
                                ->whereDate('end', '>', $end);
                        })
                        ->orWhere(function ($subQuery) use ($start, $end) {
                            $subQuery
                                ->whereDate('start', '<', $start)
                                ->whereDate('end', '>', $start)
                                ->whereDate('end', '<=', $end);
                        })
                        ->orWhere(function ($subQuery) use ($start, $end) {
                            $subQuery->whereDate('start', '<=', $start)
                                ->whereDate('end', '>=', $end);
                        });
                })
                ->whereDoesntHave('sideReservations', function (Builder $q) use ($start, $end) {
                    $q->where(function ($subQuery) use ($start, $end) {
                        $subQuery->whereDate('start', '>=', $start)
                            ->whereDate('end', '<=', $end);
                    })
                        ->orWhere(function ($subQuery) use ($start, $end) {
                            $subQuery
                                ->whereDate('start', '>=', $start)
                                ->whereDate('start', '<', $end)
                                ->whereDate('end', '>', $end);
                        })
                        ->orWhere(function ($subQuery) use ($start, $end) {
                            $subQuery
                                ->whereDate('start', '<', $start)
                                ->whereDate('end', '>', $start)
                                ->whereDate('end', '<=', $end);
                        })
                        ->orWhere(function ($subQuery) use ($start, $end) {
                            $subQuery->whereDate('start', '<=', $start)
                                ->whereDate('end', '>=', $end);
                        });
                });
        }

        return $query;
    }

    public static function getTypes(): array
    {
        return [
            [
                'id' => 'whole',
                'title' => 'Жилье целиком',
                'subtitle' => 'Все помещения полностью в распоряжении гостей.',
            ],
            [
                'id' => 'room',
                'title' => 'Комната',
                'subtitle' => 'У гостей есть своя комната и доступ к общим помещениям.',
            ],
            [
                'id' => 'hostel',
                'title' => 'Общая комната',
                'subtitle' => 'Гости спят в общей комнате или помещении, где могут находиться другие люди.',
            ],
        ];
    }

    public static function createDraft(User $user): Model|Builder
    {
        return Apartment::query()
            ->create([
                'user_id' => $user->id,
                'status' => Status::Draft,
            ]);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updateFromArray(array $data): Model|Builder
    {
        $fields = [
            // Step 1:
            'category_id',

            // Step 2:
            'type',

            // Step 3:
            'country_code',
            'state',
            'city',
            'street',
            'building',
            'housing',
            'room',
            'floor',
            'entrance',
            'index',

            // Step 4:
            'lon',
            'lat',

            // Step 5:
            'guests',
            'bedrooms',
            'beds',
            'bathrooms',

            // Step 6:
            // Step 7:

            // Step 8:
            'title',

            // Step 9:
            'description',

            // Step 10:
            'weekdays_price',
            'weekends_price',

            // Step 11:
            'fast_reserve',
        ];
        foreach ($fields as $field) {
            if (Arr::has($data, $field)) {
                $value = Arr::get($data, $field);
                $this[$field] = $value;
            }
        }

        if ($features = Arr::get($data, 'features')) {
            $this->features()->sync($features);
        }

        //Step 7
        if ($mediaIds = Arr::get($data, 'media')) {
            $medias = [];
            foreach ($mediaIds as $uuid) {
                /** @var Media $image */
                $image = $this->media()->where('uuid', $uuid)->first();
                if (! $image) {
                    continue;
                }
                if ($image?->collection_name !== 'default') {
                    $image = $image->move($this);
                }
                $medias[] = $image->getKey();
            }
            Media::setNewOrder($medias);
        }

        $this->step = Arr::get($data, 'step') + 1;

        if ($this->step === 12) {
            $this->status = Status::Pending;
        }

        $this->save();

        return $this;
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approve(): bool
    {
        return $this->update([
            'status' => Status::Published,
        ]);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', Status::Published);
    }

    public function datePrices(): HasMany
    {
        return $this->hasMany(DatePrice::class);
    }

    public function getPriceForDay(Carbon $day): int
    {
        $dayPrice = $this->datePrices()->whereDate('date', $day)->first();
        if (! $dayPrice) {
            $dayOfWeek = $day->dayOfWeek;
            if ($dayOfWeek === 5 || $dayOfWeek === 6) {
                Log::info((string) $this->weekends_price);

                return $this->weekends_price;
            }

            return $this->weekdays_price;
        }

        return $dayPrice->price;
    }

    public function getPriceForRange(Carbon $start, Carbon $end): int
    {
        $price = 0;
        $period = CarbonPeriod::create(
            $start,
            $end,
        );
        foreach ($period as $date) {
            $price += $this->getPriceForDay($date);
        }

        return $price;
    }

    public function disabledDates(): HasMany
    {
        return $this->hasMany(DisabledDate::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public static function export(Collection $collection): BinaryFileResponse
    {
        $export = new ApartmentsExport($collection);

        return Excel::download(
            export: $export,
            fileName: 'apartments.xlsx',
            writerType: \Maatwebsite\Excel\Excel::XLSX
        );
    }

    public static function import(string $filename): void
    {
        // TODO: Добавить try catch и обработку ошибок
        Excel::import(new ApartmentsImport(), $filename, 'imports');
    }

    public function ICalLinks(): HasMany
    {
        return $this->hasMany(ICalLink::class);
    }

    public function sideReservations(): HasMany
    {
        return $this->hasMany(SideReservation::class);
    }

    protected function allDisabledDays(): Attribute
    {
        return Attribute::make(
            get: function () {
                $result = [];
                $disabledDays = $this->disabledDates()
                    ->whereDate('start', '>=', now())
                    ->orderBy('start')
                    ->select('start', 'end')
                    ->get();
                foreach ($disabledDays as $item) {
                    $period = CarbonPeriod::create(
                        $item->start->setTime(15, 00),
                        $item->end->setTime(12, 00),
                    );
                    foreach ($period as $day) {
                        $result[] = $day;
                    }
                }
                $reservations = $this->reservations()
                    ->whereDate('end', '>=', now())
                    ->select('start', 'end', 'apartment_id', 'id')
                    ->get();
                foreach ($reservations as $item) {
                    $period = CarbonPeriod::create(
                        $item->start->setTime(15, 00),
                        $item->end->setTime(12, 00),
                    );
                    foreach ($period as $day) {
                        $result[] = $day;
                    }
                }

                $side_reservations = $this->sideReservations()
                    ->whereDate('end', '>=', now())
                    ->select('start', 'end', 'apartment_id', 'id')
                    ->get();
                foreach ($side_reservations as $item) {
                    $period = CarbonPeriod::create(
                        $item->start->setTime(15, 00),
                        $item->end->setTime(12, 00),
                    );
                    foreach ($period as $day) {
                        $result[] = $day;
                    }
                }
                return $result;
            },
        );
    }

    public function fullAddress(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => implode(', ', array_filter([
                Arr::get($attributes, 'city'),
                Arr::get($attributes, 'street') ? 'ул.'.Arr::get($attributes, 'street') : null,
                Arr::get($attributes, 'building') ? 'д.'.Arr::get($attributes, 'building') : null,
                Arr::get($attributes, 'housing') ? 'корп.'.Arr::get($attributes, 'housing') : null,
                Arr::get($attributes, 'room') ? 'кв.'.Arr::get($attributes, 'room') : null,
                Arr::get($attributes, 'floor') ? 'эт.'.Arr::get($attributes, 'floor') : null,
                Arr::get($attributes, 'entrance') ? 'под.'.Arr::get($attributes, 'entrance') : null,
            ]))
        );
    }

    public function scopeOrder(Builder $builder): Builder
    {
        $seed = '"'.Carbon::now()->hour.Str::substr(Auth::id(), 0, 5).'"';

        return $builder->inRandomOrder($seed);
    }
}
