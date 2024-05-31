<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\AddTokenToHttpRequest::class,
            // \Clockwork\Support\Laravel\ClockworkMiddleware::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\AddTokenToHttpRequest::class,
            // \Clockwork\Support\Laravel\ClockworkMiddleware::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'allowedIP' => \App\Http\Middleware\CheckAllowedIPMiddleware::class,
        'superadmin' => \App\Http\Middleware\UserAccess::class . ':superadmin',
        'deposit' => \App\Http\Middleware\UserAccess::class . ':deposit',
        'withdraw' => \App\Http\Middleware\UserAccess::class . ':withdraw',
        'manual_transaction' => \App\Http\Middleware\UserAccess::class . ':manual_transaction',
        'history_coin' => \App\Http\Middleware\UserAccess::class . ':history_coin',
        'member_list' => \App\Http\Middleware\UserAccess::class . ':member_list',
        'history_transaction' => \App\Http\Middleware\UserAccess::class . ':history_transaction',
        'referral' => \App\Http\Middleware\UserAccess::class . ':referral',
        'history_game' => \App\Http\Middleware\UserAccess::class . ':history_game',
        'member_outstanding' => \App\Http\Middleware\UserAccess::class . ':member_outstanding',
        'cashback_rollingan' => \App\Http\Middleware\UserAccess::class . ':cashback_rollingan',
        'report' => \App\Http\Middleware\UserAccess::class . ':report',
        'bank' => \App\Http\Middleware\UserAccess::class . ':bank',
        'memo' => \App\Http\Middleware\UserAccess::class . ':memo',
        'agent' => \App\Http\Middleware\UserAccess::class . ':agent',
        'analytic' => \App\Http\Middleware\UserAccess::class . ':analytic',
        'content' => \App\Http\Middleware\UserAccess::class . ':content',
        'apk_setting' => \App\Http\Middleware\UserAccess::class . ':apk_setting',
        'memo_other' => \App\Http\Middleware\UserAccess::class . ':memo_other',
    ];
}
