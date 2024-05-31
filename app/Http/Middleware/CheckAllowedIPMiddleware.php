<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Allowedip;
use Symfony\Component\HttpFoundation\Response;

class CheckAllowedIPMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $allowedIPs = ['192.168.1.1', '10.0.0.1']; // Add your allowed IP addresses here
        $allowedIPs = Allowedip::pluck('ip_address')->toArray();

        $clientIP = $request->ip();

        if (!in_array($clientIP, $allowedIPs)) {
            abort(404);
        }

        return $next($request);
    }
}
