<?php

declare(strict_types=1);

namespace App\Models\Chat;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class Chat extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [
        'id',
        'created_at'
    ];

    protected $with = [
        'apartment'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function last_message(): HasOne
    {
        return $this->hasOne(Message::class)->latest();
    }
}
