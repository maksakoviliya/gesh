<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Apartments\Status;
use App\Enums\Apartments\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                return $q->where('slug', $request->query('category'));
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
        ];
        foreach ($fields as $field) {
            if ($value = Arr::get($data, $field)) {
                $this[$field] = $value;
            }
        }

        if ($category = Arr::get($data, 'category_id')) {
            $this->categories()->sync([$category]);
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
            'status' => Status::Published
        ]);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', Status::Published);
    }
}
