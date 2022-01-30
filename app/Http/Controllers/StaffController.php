<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $users = User::with(['position', 'department'])->orderBy('active', 'DESC')->orderBy('name')->paginate(10);
        return view('staff.index', ['users'=>$users]);
    }

    public function show(User $user)
    {
        return view('staff.show', [
            'user' => $user,
            'departments' => Department::get(),
            'positions' => Position::get()
        ]);
    }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'active' => 'required|boolean',
            'annual_leave' => 'required|numeric|min:0',
        ]);

        $user->update($attributes);

        return back()->with('success', 'Status staf berjaya dikemaskini.');
    }
}
