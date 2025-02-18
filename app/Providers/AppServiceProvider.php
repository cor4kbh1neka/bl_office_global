<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Xdpwd;
use App\Models\UserAccess;
use App\Models\Outstanding;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->defineDynamicGates();
        // Event::listen(Authenticated::class, function ($event) {
        //     View::share('dataCount', $this->getDataCount());
        // });
    }

    private function getDataCount()
    {
        $countDataDP = Xdpwd::where('jenis', 'DP')->where('status', 0)->count();
        $countDataWD = Xdpwd::where('jenis', 'WD')->where('status', 0)->count();

        $dataOuts = Outstanding::get();
        $dataOuts = $dataOuts->groupBy('username')->map(function ($group) {
            $totalAmount = $group->sum('amount');
            $count = $group->count();
            return [
                'username' => $group->first()['username'],
                'totalAmount' => $totalAmount,
                'count' => $count,
            ];
        })->count();
        $responseMemo = Http::withHeaders([
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->get(env('DOMAIN') . '/memo');
        $resultMemo = $responseMemo->json();

        if ($responseMemo->successful()) {
            $resultMemo = $responseMemo->json();
            if ($resultMemo['status'] == 'success') {
                $countMemo = count($resultMemo['data']);
            } else {
                $countMemo = 0;
            }
        } else {
            $countMemo = 0;
        }

        return [
            'countDP' => $countDataDP,
            'countWD' => $countDataWD,
            'countOuts' => $dataOuts,
            // 'countMemo' => $countMemo
            'countMemo' => 0
        ];
    }

    private function defineDynamicGates(): void
    {
        $columns = Schema::getColumnListing('user_access');
        $excludedColumns = ['id', 'updated_at', 'created_at'];
        $process = array_diff($columns, $excludedColumns);

        foreach ($process as $column) {
            Gate::define($column, function (User $user) use ($column) {
                $cache = Cache::get('user_access_' . $user->username);

                if ($cache) {
                    $userAccess = $cache;
                }

                $userAccess = $user->userAccess ? $user->userAccess->toArray() : null;
                return $userAccess === null || $userAccess[$column] === 1;
            });
        }
    }
}
