<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Instructors\Type;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class Instructor extends Model implements HasMedia
{
    use HasFactory;
    use HasUlids;
    use InteractsWithMedia;

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $casts = [
        'type' => Type::class,
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile()
            ->withResponsiveImages();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
