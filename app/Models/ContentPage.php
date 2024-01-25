<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentPage
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContentPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContentPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContentPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class ContentPage extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [
        'id',
        'created_at',
    ];
}
