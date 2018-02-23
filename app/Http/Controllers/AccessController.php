<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AccessController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout']]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();

        return view('access.logout');
    }

    public function google_login(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback(Request $request)
    {
        $google_user = Socialite::driver('google')->user();

        $lookedup_user = User::where('email', $google_user->email)->first();

        if (empty($lookedup_user))
        {
            return view('access.login_not_auth');
        }

        // Update data at every logon
        $lookedup_user->name = $google_user->name;
        $lookedup_user->avatar = $google_user->avatar;
        $lookedup_user->save();

        Auth::loginUsingId($lookedup_user->id, true);

        return redirect('/dashboard');
    }
}
