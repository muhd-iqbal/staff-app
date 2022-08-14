<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function show()
    {
        $user = User::find(auth()->id());
        return view('profile.show', [
            'user' => $user,
            'departments' => Department::get(),
            'positions' => Position::get()
        ]);
    }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'name' => 'required|min:5|max:255',
            'phone' => 'required|min:10|max:15|unique:users,email,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'icno' => 'required|min:12|max:12,unique:users,icno,' . $user->id,
            'birthday' => 'required|date',
            'address' => 'required|max:255',
            'joined_at' => 'required|date',
            'left_at' => 'nullable|date',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'qualification' => 'required|max:255',
            'bank_name' => 'required|max:20',
            'bank_acc' => 'required|max:20',
        ]);

        $attributes['birthday_reminder'] = get_next_birthday($attributes['birthday']);

        $user->update($attributes);

        return back()->with('success', 'Maklumat berjaya Diubah!');
    }
}
