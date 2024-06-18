<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->status != 1) {
            Auth::logout();
            return redirect('/memberlistds')->withErrors([
                'email' => 'Akun Anda telah di Suspend. Silakan hubungi administrator.',
            ]);
        }

        return $next($request);
    }
}
