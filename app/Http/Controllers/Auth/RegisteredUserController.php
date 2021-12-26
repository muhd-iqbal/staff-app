<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use App\Models\UserPermission;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register', ['departments'=>Department::all(), 'positions'=>Position::all()]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'icno' => ['required', 'integer', 'min:12', 'unique:users'],
            'phone' => ['required', 'regex:/(01)[0-9]/', 'unique:users'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'position_id' => ['required', 'integer', 'exists:positions,id'],
            'joined_at' => ['required', 'date'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'icno' => $request->icno,
            'phone' => $request->phone,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'joined_at' => $request->joined_at,
            'active' => 1,
            'password' => Hash::make($request->password),
        ]);

        UserPermission::create([
            'user_id' => $user->id,
        ]);

        event(new Registered($user));

//        Auth::login($user);

        return redirect(RouteServiceProvider::HOME)->with('success', 'Staf '.$user['name'].' berjaya didaftar.');
    }
}
