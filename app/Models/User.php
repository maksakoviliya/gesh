<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\SocialAuthProvider;
use Database\Factories\UserFactory;
use Dotenv\Util\Str;
use Eloquent;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;
use Random\RandomException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string|null $email
 * @property string|null $avatar
 * @property |null $phone
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $phone_verified_at
 * @property string|null $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $social_id
 * @property SocialAuthProvider|null $social_provider
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Apartment> $apartments
 * @property-read int|null $apartments_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read string $profile_photo_url
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 *
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions, $without = false)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null, $without = false)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePhoneVerifiedAt($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereSocialId($value)
 * @method static Builder|User whereSocialProvider($value)
 * @method static Builder|User whereTwoFactorConfirmedAt($value)
 * @method static Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static Builder|User whereTwoFactorSecret($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User withoutPermission($permissions)
 * @method static Builder|User withoutRole($roles, $guard = null)
 *
 * @mixin Eloquent
 */
class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use HasUlids;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $keyType = 'string';

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    protected $with = [
        'roles',
    ];

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'password',
        'social_id',
        'telegram_chat_id',
        'social_provider',
    ];

    protected $casts = [
        'phone' => E164PhoneNumberCast::class . ':RU',
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'social_provider' => SocialAuthProvider::class,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }

    public function routeNotificationForTelegram()
    {
        return $this->telegram_id ?? 381110669;
    }


    public function generateTelegramCode(string $chat_id): int
    {
        try {
            $code = random_int(1000, 9999);
        } catch (RandomException $e) {
            $code = 1010;
        }
        TelegramAuthCode::query()
            ->create([
                'code' => $code,
                'user_id' => $this->id,
                'chat_id' => $chat_id,
                'expires_at' => Carbon::now()->addHour()
            ]);
        return $code;
    }

    public function telegramAuthCodes(): HasMany
    {
        return $this->hasMany(TelegramAuthCode::class);
    }
}
