<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\Reservation\CreatedEvent as ReservationCreatedEvent;
use App\Events\Reservation\PaidEvent;
use App\Events\ReservationRequest\CreatedEvent as ReservationRequestCreatedEvent;
use App\Events\Transfer\RegularDriveBookedEvent;
use App\Listeners\Reservation\CreatedListener as ReservationCreatedListener;
use App\Listeners\Reservation\PaidListener;
use App\Listeners\ReservationRequest\CreatedListener as ReservationRequestCreatedListener;
use App\Listeners\Transfer\RegularDriveBookedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Google\GoogleExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\VKontakte\VKontakteExtendSocialite;

final class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            VKontakteExtendSocialite::class.'@handle',
            GoogleExtendSocialite::class.'@handle',
        ],
        ReservationRequestCreatedEvent::class => [
            ReservationRequestCreatedListener::class,
        ],
        ReservationCreatedEvent::class => [
            ReservationCreatedListener::class,
        ],
        PaidEvent::class => [
            PaidListener::class,
        ],
        RegularDriveBookedEvent::class => [
            RegularDriveBookedListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
