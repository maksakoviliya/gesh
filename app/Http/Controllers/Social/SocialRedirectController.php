<?php

declare(strict_types=1);

namespace App\Http\Controllers\Social;

use App\Enums\SocialAuthProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialRedirectController extends Controller
{
    /**
     * @param Request $request
     * @param SocialAuthProvider $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
     */
    public function __invoke(Request $request, SocialAuthProvider $provider): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return Socialite::driver($provider->value)->redirect();
    }
}
