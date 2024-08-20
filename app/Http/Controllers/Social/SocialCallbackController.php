<?php

declare(strict_types=1);

namespace App\Http\Controllers\Social;

use App\Enums\SocialAuthProvider;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialCallbackController extends Controller
{
    public function __invoke(Request $request, SocialAuthProvider $provider): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $socialUser = Socialite::driver($provider->value)->user();

        /** @var User $user */
        $user = User::query()
            ->firstOrCreate([
                'email' => $socialUser->email,
            ], [
                'social_id' => $socialUser->id,
                'social_provider' => $provider,
                'name' => $socialUser->name,
                'avatar' => $socialUser->avatar,
                'email_verified_at' => Carbon::now(),
            ]);

        if (! $user) {
            return redirect(route('home'));
        }
        Auth::login($user);

        return redirect(route('home'));
    }
}
