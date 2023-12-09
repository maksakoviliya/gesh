<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Apartments\Status;
use App\Enums\Apartments\Type;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DatePrice> $datePrices
 * @property-read int|null $date_prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DisabledDate> $disabledDates
 * @property-read int|null $disabled_dates_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Feature> $features
 * @property-read int|null $features_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\ApartmentFactory factory($count = null, $state = [])
 * @method static Builder|Apartment filter(\Illuminate\Http\Request $request)
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
 *
 * @mixin \Eloquent
 */
final class Apartment extends Model implements HasMedia
{
    use HasFactory, HasUlids, InteractsWithMedia;

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
            $start = Carbon::createFromFormat('d_m_Y', $request->get('start'));
            $end = Carbon::createFromFormat('d_m_Y', $request->get('end'));
            $query->whereDoesntHave('reservations', function (Builder $query) use ($start, $end) {
                $query->whereDate('start', '>', $start)
                    ->whereDate('end', '<', $end->subDay());
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

        if ($images = Arr::get($data, 'media')) {
            foreach ($images as $image) {
                if (! $image instanceof UploadedFile) {
                    continue;
                }
                $this->addMedia($image)
                    ->toMediaCollection();
            }
        }

        if ($remove = Arr::get($data, 'remove')) {
            foreach ($remove as $id) {
                Media::query()
                    ->find($id)
                    ->delete();
            }
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
        Log::info((string) $day->format('d.m.Y'));
        $dayPrice = $this->datePrices()->whereDate('date', $day)->first();
        if (! $dayPrice) {
            $dayOfWeek = $day->dayOfWeek;
            Log::info((string) $dayOfWeek);
            if ($dayOfWeek === 5 || $dayOfWeek === 6) {
                Log::info((string) $this->weekends_price);

                return $this->weekends_price;
            }
            Log::info((string) $this->weekdays_price);

            return $this->weekdays_price;
        }
        Log::info((string) $dayPrice->price);

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
        $this->hasMany(Reservation::class);
    }
}
