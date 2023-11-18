<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Apartments\Status;
use App\Enums\Apartments\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
        if ($categoryId = Arr::get($data, 'category')) {
            $this->category_id = $categoryId;
        }
        if ($type = Arr::get($data, 'type')) {
            $this->type = $type;
        }
        $this->step = Arr::get($data, 'step') + 1;
        $this->save();

        return $this;
    }
}
