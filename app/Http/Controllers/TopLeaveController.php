<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopLeaveController extends Controller
{
    public function show()
    {
        $users = DB::table('leaves')
            ->leftJoin('users', 'users.id', '=', 'leaves.user_id')
            ->leftJoin('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('leaves.hr_approval', '=', 1)
            ->where('leaves.approved', '=', 0)
            ->where('leaves.active', '=', 1)
            ->select('leaves.*', 'leave_types.name AS type_name', 'users.name AS user_name')
            ->orderBy('leaves.created_at')
            ->get();

        return view('leaves.approval-top', [
            'leaves' => $users
        ]);
    }

    public function update(Leave $leave)
    {
        DB::table('leaves')
            ->where('id', $leave->id)
            ->update(['approved' => 1]);

        $user = DB::table('users')
            ->where('id', $leave->user_id)
            ->first();
        $new_remaining =  $user->leave_remaining - $leave->day;
        DB::table('users')
            ->where('id', $leave->user_id)
            ->update(['leave_remaining' => $new_remaining]);

        return back()->with('success', 'Cuti diluluskan!');
    }

    public function delete(Leave $leave)
    {
        DB::table('leaves')
            ->where('id', $leave->id)
            ->update(['active' => 0]);

        return back()->with('success', 'Cuti dibatalkan!');
    }
}
