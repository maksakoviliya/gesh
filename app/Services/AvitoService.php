<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Apartment;
use App\Models\SideReservation;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use http\Exception\RuntimeException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class AvitoService
{
    public function authorizeCallbackCode(string $code): void
    {
        if (!$code) {
            return;
        }

        if (!$user = Auth::user()) {
            return;
        }

        if ($user->avito_access_token) {
            return;
        }

        $response = Http::asForm()->post('https://api.avito.ru/token/', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.avito.client_id'),
            'client_secret' => config('services.avito.secret'),
            'code' => $code,
        ]);

        if (!$response->successful()) {
            Log::error("Authorize avito error: {$response->body()}");

            return;
        }

        $this->updateUserTokens($user, $response->json());
    }

    public function refreshToken(User $user): void
    {
        if (!$refresh_token = $user->avito_refresh_token) {
            Log::error('Refresh token error: refresh token not found.');

            return;
        }

        $response = Http::asForm()->post('https://api.avito.ru/token/', [
            'grant_type' => 'refresh_token',
            'client_id' => config('services.avito.client_id'),
            'client_secret' => config('services.avito.secret'),
            'refresh_token' => $refresh_token,
        ]);

        if (!$response->successful()) {
            Log::error("Refresh token error: {$response->body()}");

            return;
        }

        $this->updateUserTokens($user, $response->json());
    }

    protected function updateUserTokens(User $user, array $data): bool
    {
        $accessToken = Arr::get($data, 'access_token');
        return $user->update([
            'avito_access_token' => $accessToken,
            'avito_refresh_token' => Arr::get($data, 'refresh_token'),
            'avito_user_id' => $this->getAvitoUserId($accessToken)
        ]);
    }

    public function getAvitoUserId(string $accessToken): ?int
    {
        if (!$accessToken) {
            Log::error('Get avito user id: Empty access token.');
            return null;
        }
        $response = Http::withToken($accessToken)->get('https://api.avito.ru/core/v1/accounts/self');

        if (!$response->successful()) {
            Log::error("Get avito user id: {$response->body()}");
            return null;
        }

        $data = $response->json();

        return Arr::get($data, 'id');
    }

    public function syncDates(Apartment $apartment): void
    {
        $user = $apartment->user;
        $this->validateUser($user);

        $attempt = 0;
        while ($attempt < 3) {
            $response = $this->fetchBookings($user, $apartment);

            if ($response->successful()) {
                $data = $response->json();
                $this->processAvitoDatesResponse($apartment, $data);
                return;
            }

            if ($response->status() === 403) {
                $this->refreshToken($user);
                $user->refresh();
                $attempt++;
            } else {
                throw new RuntimeException('Failed to fetch bookings: ' . $response->body());
            }
        }

        throw new RuntimeException('Max attempts reached. Unable to sync dates.');
    }

    private function validateUser($user): void
    {
        if (!$user) {
            throw new RuntimeException('User not found.');
        }

        if (!$user->avito_access_token) {
            throw new RuntimeException('User avito access token not found.');
        }

        if (!$user->avito_user_id) {
            throw new RuntimeException('User avito user id not found.');
        }
    }

    private function fetchBookings(User $user, Apartment $apartment): PromiseInterface|Response
    {
        return Http::withToken($user->avito_access_token)
            ->get(
                "https://api.avito.ru/realty/v1/accounts/{$user->avito_user_id}/items/{$apartment->avito_id}/bookings",
                [
                    'date_end' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                    'date_start' => Carbon::now()->format('Y-m-d'),
                ]
            );
    }

    public function processAvitoDatesResponse(Apartment $apartment, array $data)
    {
        Log::info(json_encode($data));
        $bookings = Arr::get($data, 'bookings');
        Log::info(json_encode($bookings));
        if (!count($bookings)) {
            Log::info('Empty bookings data for apartment: ' . $apartment->id);
            return;
        }

        $processed = [];
        foreach ($bookings as $booking) {
            $sideReservation = SideReservation::query()->updateOrCreate([
                'apartment_id' => $apartment->id,
                'start' => Carbon::parse($booking->check_in)->setTime(15, 0),
                'end' => Carbon::parse($booking->check_out)->setTime(12, 0),
                'description' => '',
                'summary' => $booking->avito_booking_id,
            ]);
            $processed[] = $sideReservation->id;
        }

        SideReservation::query()
            ->where('apartment_id', $apartment->id)
            ->whereNotIn('id', $processed)
            ->delete();
    }
}
