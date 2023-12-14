<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class ContentPage extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [
        'id',
        'created_at',
    ];
}
