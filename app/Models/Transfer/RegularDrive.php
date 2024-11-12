<?php

declare(strict_types=1);

namespace App\Models\Transfer;

use App\Enums\Transfer\RegularDriveStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class RegularDrive extends Model implements HasMedia
{
    use HasFactory;
    use HasUlids;
    use InteractsWithMedia;

    protected $guarded = [
        'id', 'created_at',
    ];

    protected $casts = [
        'status' => RegularDriveStatus::class,
        'start_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('status', RegularDriveStatus::ACTIVE);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')
            ->singleFile()
            ->withResponsiveImages()
            ->useFallbackUrl('/img/ServicesBanner/Transfer/transfer_w_960.jpg')
            ->useFallbackPath(public_path('/img/ServicesBanner/Transfer/transfer_w_960.jpg'));
    }
}
