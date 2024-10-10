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

/**
 * App\Models\Instructor
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string|null $user_id
 * @property Type $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereUserId($value)
 *
 * @mixin \Eloquent
 */
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
