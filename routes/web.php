<?php

declare(strict_types=1);

use App\Http\Controllers\Account\AccountIndexController;
use App\Http\Controllers\Account\AccountProfileController;
use App\Http\Controllers\Account\Apartments\AccountChatsController;
use App\Http\Controllers\Account\Apartments\CalendarController;
use App\Http\Controllers\Account\Apartments\CreateController;
use App\Http\Controllers\Account\Apartments\ListController;
use App\Http\Controllers\Account\Apartments\OwnerChatController;
use App\Http\Controllers\Account\Apartments\PendingController;
use App\Http\Controllers\Account\Apartments\StepController;
use App\Http\Controllers\Account\Apartments\StoreController;
use App\Http\Controllers\Account\Apartments\UpdateCalendarController;
use App\Http\Controllers\Account\Apartments\UpdatePriceController;
use App\Http\Controllers\Account\Reservations\ReservationsListController;
use App\Http\Controllers\Apartments\ChatController;
use App\Http\Controllers\ApartmentShowController;
use App\Http\Controllers\Chat\Messages\MessageStoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeMapController;
use App\Http\Controllers\ReservationRequest\ReservationRequestRejectController;
use App\Http\Controllers\ReservationRequest\ReservationRequestStoreController;
use App\Http\Controllers\ReservationRequest\ReservationRequestSubmitController;
use App\Http\Controllers\Reservations\ReservationPayController;
use App\Http\Controllers\Reservations\ReservationViewController;
use App\Http\Controllers\Search\SearchCityController;
use App\Http\Controllers\Social\SocialCallbackController;
use App\Http\Controllers\Social\SocialRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/map', HomeMapController::class)->name('home.map');
Route::get('/apartments/{apartment}', ApartmentShowController::class)->name('apartment');

// Social Auth
Route::get('/auth/redirect/{provider}', SocialRedirectController::class)->name('social_redirect');
Route::get('/auth/callback/{provider}', SocialCallbackController::class);

Route::middleware('auth:sanctum')->group(function () {
    // Account
    Route::prefix('account')
        ->as('account.')
        ->group(function () {
            Route::get('/', AccountIndexController::class)->name('index');
            Route::get('profile', AccountProfileController::class)->name('profile');

            // Apartments
            Route::prefix('apartments')
                ->as('apartments.')
//                ->namespace('App\\Http\\Controllers\\Account\\Apartments\\')
                ->group(function () {
                    Route::get('/', ListController::class)->name('list');
                    Route::get('create', CreateController::class)->name('create');
                    Route::get('{apartment}/step/{step}', StepController::class)->name('step');
                    Route::post('{apartment}/store', StoreController::class)->name('store');
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

            // Chat
            Route::prefix('chat')->as('chat.')->group(function () {
                Route::post('{chat}', MessageStoreController::class)->name('messages.store');
            });

            // Reservations
            Route::prefix('reservations')
                ->as('reservations.')->group(function () {
                    Route::get('/', ReservationsListController::class)->name('list');
                    Route::get('{reservation}/pay', ReservationPayController::class)->name('pay');
                    Route::get('{reservation}', ReservationViewController::class)->name('view');
                });
        });

    Route::post('{apartment}/reservation-requests', ReservationRequestStoreController::class)->name('reservation-requests.store');
});

Route::post('search/city', SearchCityController::class)->name('search.city');
//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return Inertia::render('Dashboard');
//    })->name('dashboard');
//});
//Route::get('test', \App\Http\Controllers\TestContreoller::class);
