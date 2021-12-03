<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        return view('leaves.types', [
            'types' => LeaveType::all(),
        ]);
    }

    public function update(LeaveType $type)
    {
        $attributes = request()->validate([
            'approval' => 'required|min:0|max:1',
        ]);

        $type->update($attributes);

        return redirect('/top/leave-types')->with('success', 'Kelulusan Berjaya Diubah');
    }
}
