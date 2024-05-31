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
                'x-customblhdrs' => '09c90c1d6e1b82015737f88d5f5b827060a57c874babe97f965aaa68072585191ce0eab75404312f4f349ee70029404c2d8f66698b6a4da18990445d1437ff79',
                'Content-Type' => 'application/json; charset=UTF-8',
            ]);
        });

        return $next($request);
    }
}
