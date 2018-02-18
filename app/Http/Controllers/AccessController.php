<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AccessController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            return view('login_not_auth');
        }
        elseif ($lookedup_user->name == 'N/A')
        {
            $lookedup_user->name = $google_user->name;
            $lookedup_user->avatar = $google_user->avatar;
            $lookedup_user->save();
        }

        Auth::loginUsingId($lookedup_user->id, true);

        return redirect($this->redirectTo);
    }
}
