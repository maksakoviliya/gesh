<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class Apartment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'rooms',
        'price',
        'address',
        'guests'
    ];

    protected $with = [
        'media'
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
}
