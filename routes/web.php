<?php

declare(strict_types=1);

use App\Http\Controllers\Account\AccountIndexController;
use App\Http\Controllers\Account\AccountProfileController;
use App\Http\Controllers\Account\Apartments\AccountChatsController;
use App\Http\Controllers\Account\Apartments\CalendarController;
use App\Http\Controllers\Account\Apartments\CreateController;
use App\Http\Controllers\Account\Apartments\DeleteController;
use App\Http\Controllers\Account\Apartments\ListController;
use App\Http\Controllers\Account\Apartments\OwnerChatController;
use App\Http\Controllers\Account\Apartments\PendingController;
use App\Http\Controllers\Account\Apartments\RemoveApartmentMediaController;
use App\Http\Controllers\Account\Apartments\StepController;
use App\Http\Controllers\Account\Apartments\StoreApartmentMediaController;
use App\Http\Controllers\Account\Apartments\StoreController;
use App\Http\Controllers\Account\Apartments\UpdateCalendarController;
use App\Http\Controllers\Account\Apartments\UpdatePriceController;
use App\Http\Controllers\Account\Notifications\NotificationsIndexController;
use App\Http\Controllers\Account\Notifications\NotificationsReadController;
use App\Http\Controllers\Account\Profile\AccountProfileUpdateController;
use App\Http\Controllers\Account\Reservations\ReservationsListController;
use App\Http\Controllers\Apartments\ApartmentShowController;
use App\Http\Controllers\Apartments\ChatController;
use App\Http\Controllers\Chat\Messages\MessageStoreController;
use App\Http\Controllers\Content\PolicyPageController;
use App\Http\Controllers\Content\RulesPageController;
use App\Http\Controllers\DisabledDates\DeleteDisabledDateController;
use App\Http\Controllers\GetMediaController;
use App\Http\Controllers\HasUnreadNotificationsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeMapController;
use App\Http\Controllers\Instructors\InstructorsListController;
use App\Http\Controllers\Instructors\InstructorsScheduleController;
use App\Http\Controllers\Instructors\InstructorsViewController;
use App\Http\Controllers\Reservation\ReservationVoucherController;
use App\Http\Controllers\ReservationRequest\ReservationRequestRejectController;
use App\Http\Controllers\ReservationRequest\ReservationRequestStoreController;
use App\Http\Controllers\ReservationRequest\ReservationRequestSubmitController;
use App\Http\Controllers\Reservations\ReservationPayController;
use App\Http\Controllers\Reservations\ReservationPayRedirectController;
use App\Http\Controllers\Reservations\ReservationViewController;
use App\Http\Controllers\Search\SearchCityController;
use App\Http\Controllers\Social\SocialCallbackController;
use App\Http\Controllers\Social\SocialRedirectController;
use App\Http\Controllers\Telegram\TelegramWebhookController;
use App\Http\Controllers\TestContreoller;
use App\Http\Controllers\Transfer\TelegramBotController;
use App\Http\Controllers\Transfer\TransferIndexController;
use App\Http\Controllers\Transfer\TransferRegularDriveBookedController;
use App\Http\Controllers\Transfer\TransferRegularDriveBookingController;
use App\Http\Controllers\Transfer\TransferRegularDriveViewController;
use App\Http\Controllers\Transfer\TransferScheduleController;
use Illuminate\Support\Facades\Route;

Route::post('{token}/webhook', TelegramWebhookController::class);

Route::get('/', HomeController::class)->name('home');
Route::get('/map', HomeMapController::class)->name('home.map');
Route::get('/apartments/{apartment}', ApartmentShowController::class)->name('apartment');

// Instructors
Route::prefix('instructors')
    ->as('instructors.')
    ->group(function () {
        Route::get('/', InstructorsListController::class)->name('list');
        Route::get('{instructor}', InstructorsViewController::class)->name('view');
        Route::post('{instructor}/schedule', InstructorsScheduleController::class)->name('schedule');
    });

// Transfer
Route::prefix('transfer')
    ->as('transfer.')
    ->group(function () {
        Route::get('/', TransferIndexController::class)->name('index');
        Route::get('regular-drive/{drive}', TransferRegularDriveViewController::class)->name('regular-ride.view');
        Route::post('regular-drive/{drive}', TransferRegularDriveBookingController::class)
            ->middleware('auth:sanctum')
            ->name('regular-ride.booking');
        Route::get('regular-drive/booking/{booking}', TransferRegularDriveBookedController::class)
            ->middleware('auth:sanctum')
            ->name('regular-ride.booked');
        Route::post('/', TransferScheduleController::class)->name('schedule');

        Route::post(
            'telegram/{token}/webhook',
            [TelegramBotController::class, 'processWebhook']
        )->name('telegram.webhook');
    });

Route::get('/policy', PolicyPageController::class)->name('policy');
Route::get('/rules', RulesPageController::class)->name('rules');

// Social Auth
Route::get('/auth/redirect/{provider}', SocialRedirectController::class)->name('social_redirect');
Route::get('/auth/callback/{provider}', SocialCallbackController::class);

Route::middleware('auth:sanctum')->group(function () {
    // Account
    Route::prefix('account')
        ->as('account.')
        ->group(function () {
            Route::get('/', AccountIndexController::class)->name('index');

            Route::prefix('profile')
                ->as('profile.')
                ->group(function () {
                    Route::get('/', AccountProfileController::class)->name('index');
                    Route::post('update', AccountProfileUpdateController::class)->name('update');
                });

            // Apartments
            Route::prefix('apartments')
                ->as('apartments.')
                ->group(function () {
                    Route::get('/', ListController::class)->name('list');
                    Route::get('create', CreateController::class)->name('create');
                    Route::get('{apartment}/step/{step}', StepController::class)->name('step');
                    Route::post('{apartment}/media', StoreApartmentMediaController::class)->name('media.store');
                    Route::post('{apartment}/remove-media', RemoveApartmentMediaController::class)->name('media.remove');
                    Route::post('{apartment}/store', StoreController::class)->name('store');
                    Route::post('{apartment}/delete', DeleteController::class)->name('delete');
                    Route::get('{apartment}/pending', PendingController::class)->name('pending');
                    Route::get('{apartment}/calendar', CalendarController::class)->name('calendar');
                    Route::get('{apartment}/chats', AccountChatsController::class)->name('chats');
                    Route::get('{apartment}/chats/{chat}', OwnerChatController::class)->name('owner.chat');
                    Route::post('{apartment}/calendar/update', UpdateCalendarController::class)->name('calendar.update');
                    Route::post('{apartment}/price/update', UpdatePriceController::class)->name('price.update');
                    Route::get('{apartment}/chat', ChatController::class)->name('chat');
                });

            // Reservation Requests
            Route::prefix('reservation-requests')
                ->as('reservation-requests.')
                ->group(function () {
                    Route::post('{reservationRequest}/reject', ReservationRequestRejectController::class)->name('reject');
                    Route::post('{reservationRequest}/submit', ReservationRequestSubmitController::class)->name('submit');
                });

            // Notifications
            Route::prefix('notifications')
                ->as('notifications.')
                ->group(function () {
                    Route::get('/', NotificationsIndexController::class)->name('index');
                    Route::post('{notification}', NotificationsReadController::class)->name('read');
                });

            // Chat
            Route::prefix('chat')->as('chat.')->group(function () {
                Route::post('{chat}', MessageStoreController::class)->name('messages.store');
            });

            // Reservations
            Route::prefix('reservations')
                ->as('reservations.')->group(function () {
                    Route::get('/', ReservationsListController::class)->name('list');
                    Route::get('{reservation}/pay', ReservationPayController::class)->name('pay');
                    Route::get('{reservation}/pay-redirect', ReservationPayRedirectController::class)->name('pay.redirect');
                    Route::get('{reservation}/voucher', ReservationVoucherController::class)->name('voucher');
                    Route::get('{reservation}', ReservationViewController::class)->name('view');
                });

            Route::delete('disabled-dates/{disabledDate}', DeleteDisabledDateController::class)->name('disabled-dates.delete');

        });

    Route::post('{apartment}/reservation-requests', ReservationRequestStoreController::class)
        ->middleware('HasPhoneMiddleware')
        ->name('reservation-requests.store');

    // Profile
    Route::get('has-unread-notifications', HasUnreadNotificationsController::class)->name('has_unread_notifications');
});

Route::post('search/city', SearchCityController::class)->name('search.city');

Route::get('media/{id}', GetMediaController::class)->name('media');
//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return Inertia::render('Dashboard');
//    })->name('dashboard');
//});
Route::get('test', TestContreoller::class);
