<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class AddTokenToHttpRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Http::macro('withTokenHeader', function () {
            return Http::withHeaders([
                'x-customblhdrs' => env('XCUSTOMBLHDRS'),
                'Content-Type' => 'application/json; charset=UTF-8',
            ]);
        });

        return $next($request);
    }
}
