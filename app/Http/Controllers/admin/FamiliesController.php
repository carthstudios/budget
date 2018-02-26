<?php

namespace App\Http\Controllers\Admin;

use App\Family;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class FamiliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Request $request)
    {
        return view('admin.families.view');
    }

    public function member_add_new(Request $request)
    {
        $email      = $request->get('email');
        $family_id  = $request->get('family_id');

        if (User::where('email', $email)->get()->count() > 0)
        {
            return redirect()->back()->withErrors(['User already existing! Cannot be re-added!']);
        }

        $user = new User;
        $user->email        = $email;
        $user->family_id    = $family_id;
        $user->save();

        return redirect()->back()->with('success', "User '" . $user->email . "' added!");
    }

    public function member_remove(Request $request, int $user_id)
    {
        $user = User::find($user_id);

        $user->family_id = null;
        $user->save();

        return redirect()->back()->with('success', "User '" . $user->email . "' removed!");
    }

    public function member_rename(Request $request)
    {
        $user_id    = $request->get('user_id');
        $name       = $request->get('name');

        $user = User::find($user_id);
        $user->name = $name;
        $user->save();

        return redirect()->back()->with('success', "User '" . $user->email . "' renamed!");
    }

    public function member_add(Request $request)
    {
        $user_id    = $request->get('user_id');
        $family_id  = $request->get('family_id');

        if ($family_id == null)
        {
            return redirect()->back()->withErrors(['You need to specify a family to add!']);
        }

        $user = User::find($user_id);
        $user->family_id = $family_id;
        $user->save();

        return redirect()->back()->with('success', "User '" . $user->email . "' added to a family!");
    }

    public function family_add(Request $request)
    {
        $family_name = $request->get('family_name');

        if (Family::where('name', $family_name)->get()->count() > 0)
        {
            return redirect()->back()->withErrors('This family already exists!');
        }

        $family = new Family;
        $family->name = $family_name;
        $family->save();

        return redirect()->back()->with('success', "Family '$family_name' created!");
    }
}
