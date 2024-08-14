<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');

        if (!$request->expectsJson()) {
            if ($request->user() && !$request->session()->has('pin_validated')) {
                // Jika pengguna sudah login dan belum validasi PIN, arahkan ke halaman validasi PIN
                return route('pin.validate');
            } else {
                // Jika belum login, arahkan ke halaman login
                session()->forget('pin_validated');
                return route('login');
            }
        }
    }
}
