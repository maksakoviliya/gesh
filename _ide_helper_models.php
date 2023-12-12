<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Apartment
 *
 * @property string $id
 * @property Status $status
 * @property int $step
 * @property string $user_id
 * @property int|null $category_id
 * @property Type|null $type
 * @property string|null $country_code
 * @property string|null $state
 * @property string|null $city
 * @property string|null $street
 * @property string|null $building
 * @property string|null $housing
 * @property string|null $room
 * @property string|null $floor
 * @property string|null $entrance
 * @property string|null $index
 * @property string|null $lon
 * @property string|null $lat
 * @property int|null $guests
 * @property int|null $bedrooms
 * @property int|null $beds
 * @property int|null $bathrooms
 * @property string|null $title
 * @property string|null $description
 * @property int|null $weekdays_price
 * @property int|null $weekends_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool|null $fast_reserve
 * @property-read Category|null $category
 * @property-read Collection<int, DatePrice> $datePrices
 * @property-read int|null $date_prices_count
 * @property-read Collection<int, DisabledDate> $disabledDates
 * @property-read int|null $disabled_dates_count
 * @property-read Collection<int, Feature> $features
 * @property-read int|null $features_count
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read User|null $user
 * @method static ApartmentFactory factory($count = null, $state = [])
 * @method static Builder|Apartment filter(Request $request)
 * @method static Builder|Apartment newModelQuery()
 * @method static Builder|Apartment newQuery()
 * @method static Builder|Apartment published()
 * @method static Builder|Apartment query()
 * @method static Builder|Apartment whereBathrooms($value)
 * @method static Builder|Apartment whereBedrooms($value)
 * @method static Builder|Apartment whereBeds($value)
 * @method static Builder|Apartment whereBuilding($value)
 * @method static Builder|Apartment whereCategoryId($value)
 * @method static Builder|Apartment whereCity($value)
 * @method static Builder|Apartment whereCountryCode($value)
 * @method static Builder|Apartment whereCreatedAt($value)
 * @method static Builder|Apartment whereDescription($value)
 * @method static Builder|Apartment whereEntrance($value)
 * @method static Builder|Apartment whereFastReserve($value)
 * @method static Builder|Apartment whereFloor($value)
 * @method static Builder|Apartment whereGuests($value)
 * @method static Builder|Apartment whereHousing($value)
 * @method static Builder|Apartment whereId($value)
 * @method static Builder|Apartment whereIndex($value)
 * @method static Builder|Apartment whereLat($value)
 * @method static Builder|Apartment whereLon($value)
 * @method static Builder|Apartment whereRoom($value)
 * @method static Builder|Apartment whereState($value)
 * @method static Builder|Apartment whereStatus($value)
 * @method static Builder|Apartment whereStep($value)
 * @method static Builder|Apartment whereStreet($value)
 * @method static Builder|Apartment whereTitle($value)
 * @method static Builder|Apartment whereType($value)
 * @method static Builder|Apartment whereUpdatedAt($value)
 * @method static Builder|Apartment whereUserId($value)
 * @method static Builder|Apartment whereWeekdaysPrice($value)
 * @method static Builder|Apartment whereWeekendsPrice($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $reservations
 * @property-read int|null $reservations_count
 */
	final class Apartment extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $description
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Apartment> $apartments
 * @property-read int|null $apartments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	final class Category extends \Eloquent {}
}

namespace App\Models\Chat{
/**
 * App\Models\Chat\Chat
 *
 * @property string $id
 * @property string $user_id
 * @property string $apartment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Apartment|null $apartment
 * @property-read \App\Models\Chat\Message|null $last_message
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Chat\Message> $messages
 * @property-read int|null $messages_count
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereApartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUserId($value)
 * @mixin \Eloquent
 */
	final class Chat extends \Eloquent {}
}

namespace App\Models\Chat{
/**
 * App\Models\Chat\Message
 *
 * @property int $id
 * @property string $user_id
 * @property string $chat_id
 * @property string|null $reservation_request_id
 * @property string|null $message
 * @property string|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read ReservationRequest|null $reservation_request
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereReservationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUserId($value)
 * @mixin \Eloquent
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DatePrice
 *
 * @property int $id
 * @property string $apartment_id
 * @property string $date
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereApartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class DatePrice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DisabledDate
 *
 * @property int $id
 * @property string $apartment_id
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate query()
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereApartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	final class DisabledDate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feature
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $subtitle
 * @property string|null $icon
 * @property int|null $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\FeatureFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Feature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Reservation
 *
 * @property string $id
 * @property string $user_id
 * @property string $apartment_id
 * @property string|null $reservation_request_id
 * @property string $start
 * @property string $end
 * @property int $guests
 * @property int $children
 * @property int $total_guests
 * @property int $range
 * @property int $price
 * @property Status $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Apartment|null $apartment
 * @property-read \App\Models\User|null $user
 * @method static Builder|Reservation newModelQuery()
 * @method static Builder|Reservation newQuery()
 * @method static Builder|Reservation query()
 * @method static Builder|Reservation whereApartmentId($value)
 * @method static Builder|Reservation whereChildren($value)
 * @method static Builder|Reservation whereCreatedAt($value)
 * @method static Builder|Reservation whereEnd($value)
 * @method static Builder|Reservation whereGuests($value)
 * @method static Builder|Reservation whereId($value)
 * @method static Builder|Reservation wherePrice($value)
 * @method static Builder|Reservation whereRange($value)
 * @method static Builder|Reservation whereReservationRequestId($value)
 * @method static Builder|Reservation whereStart($value)
 * @method static Builder|Reservation whereStatus($value)
 * @method static Builder|Reservation whereTotalGuests($value)
 * @method static Builder|Reservation whereUpdatedAt($value)
 * @method static Builder|Reservation whereUserId($value)
 * @mixin \Eloquent
 */
	final class Reservation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReservationRequest
 *
 * @property string $id
 * @property string $apartment_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon $end
 * @property int $guests
 * @property int $children
 * @property int $total_guests
 * @property int $range
 * @property int $price
 * @property Status|null $status
 * @property string|null $status_text
 * @property string|null $reservation_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Reservation|null $reservation
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereApartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereStatusText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereTotalGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereUserId($value)
 * @mixin \Eloquent
 */
	final class ReservationRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $reservation_id
 * @property int $amount
 * @property string $user_id
 * @property Status $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereReservationId($value)
 * @method static Builder|Transaction whereStatus($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @method static Builder|Transaction whereUserId($value)
 * @mixin Eloquent
 */
	final class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string|null $email
 * @property string|null $avatar
 * @property |null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $phone_verified_at
 * @property string|null $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $social_id
 * @property SocialAuthProvider|null $social_provider
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Apartment> $apartments
 * @property-read int|null $apartments_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSocialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSocialProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

