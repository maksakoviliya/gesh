<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasPhoneMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = \Auth::user();
        if (! $user->phone) {
            return redirect()->back()->with('error', 'Ваш телефон не указан! Для продолжения необходимо заполнить телефон в профиле!');
        }

        return $next($request);
    }
}
