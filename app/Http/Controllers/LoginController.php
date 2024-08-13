<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login.index', [
            'title' => 'login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'regex:/^[a-zA-Z0-9#]+$/'],
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status != 1) {
                Auth::logout();
                return back()->with('loginError', 'Akun Anda telah di Suspend. Silakan hubungi admin.');
            }

            $user->last_login = now();
            $user->ip_login = $request->getClientIp();
            $user->save();

            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Log in failed!');
    }

    public function showValidateForm()
    {
        return view('login.pin'); // Ganti dengan nama view yang sesuai
    }

    public function validatePin(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'pin1' => 'required|numeric',
        //     'pin2' => 'required|numeric',
        //     'pin3' => 'required|numeric',
        //     'pin4' => 'required|numeric',
        //     'pin5' => 'required|numeric',
        //     'pin6' => 'required|numeric',
        // ]);

        // if ($validator->fails()) {
        //     // return redirect()->back()->withErrors($validator)->withInput();
        //     return redirect()->back()->with('error', 'PIN yang Anda masukkan salah.');
        // }
        $user = Auth::user();

        $pin = $request->pin1 . $request->pin2 . $request->pin3 . $request->pin4 . $request->pin5 . $request->pin6;

        if (Hash::check($pin, $user->pin)) {
            $user->pin_attempts = 0;
            $user->save();
            $request->session()->put('pin_validated', true);
            return redirect()->intended('/depositds'); // Redirect ke halaman dashboard atau halaman tujuan setelah validasi PIN berhasil
        } else {
            $user->pin_attempts += 1;

            if ($user->pin_attempts >= 3) {
                $user->status = 3;
            }

            $user->save();
            return redirect()->back()->with('error', 'PIN yang Anda masukkan salah.'); // Redirect kembali dengan pesan error jika PIN salah
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
    public function logout()
    {

        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        request()->session()->forget('pin_validated');

        return redirect('/x314cz9kc141DDX');
    }
}
