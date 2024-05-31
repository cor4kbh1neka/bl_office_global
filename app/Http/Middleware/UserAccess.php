<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $this->userAndUserAccess();
        if (!$user) {
            abort(403, 'Mau Ngapain Coba2?');
        }
        if ($this->superadminBawaan($user) === true && $user['name'] === 'admin L21' && $user['username'] === env('XUSRADXE')) {
            $user['user_access'] = [
                'deposit' => 1,
                'withdraw' => 1,
                'manual_transaction' => 1,
                'history_coin' => 1,
                'member_list' => 1,
                'history_transaction' => 1,
                'referral' => 1,
                'history_game' => 1,
                'member_outstanding' => 1,
                'cashback_rollingan' => 1,
                'report' => 1,
                'bank' => 1,
                'memo' => 1,
                'agent' => 1,
                'analytic' => 1,
                'content' => 1,
                'apk_setting' => 1,
                'memo_other' => 1,
            ];
        }
        if ($role === 'superadmin' && $this->isSuperAdmin($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'deposit' && $this->canDeposit($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'withdraw' && $this->canWithdraw($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'manual_transaction' && $this->canManualTransaction($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'history_coin' && $this->canHistoryCoin($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'member_list' && $this->canMemberList($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'history_transaction' && $this->canHistoryTransaction($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'referral' && $this->canReferral($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'history_game' && $this->canHistoryGame($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'member_outstanding' && $this->canMemberOutstanding($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'cashback_rollingan' && $this->canCashbackRollingan($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'report' && $this->canReport($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'bank' && $this->canBank($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'memo' && $this->canMemo($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'agent' && $this->canAgent($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'analytic' && $this->canAnalytic($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'content' && $this->canContent($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'apk_setting' && $this->canApkSetting($user)) {
            abort(403, 'Action unauthorized');
        }
        if ($role === 'memo_other' && $this->canMemoOther($user)) {
            abort(403, 'Action unauthorized');
        }
        return $next($request);
    }

    private function userAndUserAccess()
    {
        $user = auth()->user();
        $userWithAccess = User::with('userAccess')->find($user->id);
        $result = $userWithAccess->toArray();
        return $result;
    }
    private function superadminBawaan($user)
    {
        return $user['divisi'] === 'superadmin';
    }
    private function isSuperAdmin($user)
    {
        return $user['user_access']['deposit'] !== 1 &&
            $user['user_access']['withdraw'] !== 1 &&
            $user['user_access']['manual_transaction'] !== 1 &&
            $user['user_access']['history_coin'] !== 1 &&
            $user['user_access']['member_list'] !== 1 &&
            $user['user_access']['history_transaction'] !== 1 &&
            $user['user_access']['referral'] !== 1 &&
            $user['user_access']['history_game'] !== 1 &&
            $user['user_access']['member_outstanding'] !== 1 &&
            $user['user_access']['report'] !== 1 &&
            $user['user_access']['bank'] !== 1 &&
            $user['user_access']['memo'] !== 1 &&
            $user['user_access']['agent'] !== 1 &&
            $user['user_access']['analytic'] !== 1 &&
            $user['user_access']['content'] !== 1 &&
            $user['user_access']['apk_setting'] !== 1 &&
            $user['user_access']['mempo_other'] !== 1;
    }
    private function canDeposit($user)
    {
        return $user['user_access']['deposit'] !== 1;
    }
    private function canWithdraw($user)
    {
        return $user['user_access']['withdraw'] !== 1;
    }
    private function canManualTransaction($user)
    {
        return $user['user_access']['manual_transaction'] !== 1;
    }
    private function canHistoryCoin($user)
    {
        return $user['user_access']['history_coin'] !== 1;
    }
    private function canMemberList($user)
    {
        return $user['user_access']['member_list'] !== 1;
    }
    private function canHistoryTransaction($user)
    {
        return $user['user_access']['history_transaction'] !== 1;
    }
    private function canReferral($user)
    {
        return $user['user_access']['referral'] !== 1;
    }
    private function canHistoryGame($user)
    {
        return $user['user_access']['history_game'] !== 1;
    }
    private function canMemberOutstanding($user)
    {
        return $user['user_access']['member_outstanding'] !== 1;
    }
    private function canCashbackRollingan($user)
    {
        return $user['user_access']['cashback_rollingan'] !== 1;
    }
    private function canReport($user)
    {
        return $user['user_access']['report'] !== 1;
    }
    private function canBank($user)
    {
        return $user['user_access']['bank'] !== 1;
    }
    private function canMemo($user)
    {
        return $user['user_access']['memo'] !== 1;
    }
    private function canAgent($user)
    {
        return $user['user_access']['agent'] !== 1;
    }
    private function canAnalytic($user)
    {
        return $user['user_access']['analytic'] !== 1;
    }
    private function canContent($user)
    {
        return $user['user_access']['content'] !== 1;
    }
    private function canApkSetting($user)
    {
        return $user['user_access']['apk_setting'] !== 1;
    }
    private function canMemoOther($user)
    {
        return $user['user_access']['memo_other'] !== 1;
    }
}
