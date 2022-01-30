<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LeaveController extends Controller
{

    protected $time = ['full' => 'Seharian', 'h-am' => 'Setengah Hari (Pagi)', 'h-pm' => 'Setengah Hari (Petang)'];

    public function index()
    {
        $user = auth()->id();
        return view('leaves.index', [
            'user' => User::find($user),
            'leaves' => Leave::where('user_id', $user)->orderBy('created_at', 'desc')->paginate(10),
            'leaves_cnt' => Leave::where('user_id', $user)->where('active', 1)->where('leave_type_id', 1)->whereYear('start', date("Y"))->sum('day'),
        ]);
    }

    public function create()
    {
        return view('leaves.create', [
            'leave_types' => LeaveType::all(),
            'time' => $this->time,
        ]);
    }

    public function store(User $user)
    {
        $leave_cnt = Leave::where('user_id', $user->id)->where('active', 1)->where('leave_type_id', 1)->whereYear('start', date("Y"))->sum('day');
        $leave_user = User::select('annual_leave')->where('id', $user->id)->get();
        $max_leave = $leave_user[0]->annual_leave - $leave_cnt;
        if (request('time') != "full") {
            $max_leave = min($max_leave, 0.5);
        }

        $attributes = request()->validate([
            'detail' => 'required|min:5|max:100',
            'start' => 'required|date',
            'return' => 'required|date|after_or_equal:start',
            'leave_type_id' => 'required|exists:leave_types,id',
            'day' => 'required|numeric|min:0.5|max:' . $max_leave,
            'time' => ['required', Rule::in(array_keys($this->time))],
            'attachment' => request('leave_type_id') != 3 ? ['image'] : ['required', 'image'],
        ]);

        $approval = LeaveType::find($attributes['leave_type_id']);
        $attributes['hr_approval'] = 1;
        $attributes['approved'] = 1;

        if ($approval->approval) {

            $attributes['hr_approval'] = 0;
            $attributes['approved'] = 0;
        }

        $attributes['user_id'] = auth()->id();

        if (isset($attributes['attachment'])) {
            $attributes['attachment'] = request()->file('attachment')->store('attachments');
        }

        Leave::create($attributes);

        return redirect('/leaves')->with('success', 'Permohonan Berjaya');
    }

    public function show()
    {
        // $pending = Leave::where('hr_approval', 0)->get();
        $users = DB::table('leaves')
            ->leftJoin('users', 'users.id', '=', 'leaves.user_id')
            ->leftJoin('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->where('hr_approval', '=', 0)
            ->select('leaves.*', 'leave_types.name AS type_name', 'users.name AS user_name')
            ->orderBy('leaves.created_at')
            ->get();

        return view('leaves.approval', [
            'leaves' => $users
        ]);
    }

    public function update(Leave $leave)
    {
        DB::table('leaves')
            ->where('id', $leave->id)
            ->update(['hr_approval' => 1, 'approved' => 1]);

        return back()->with('success', 'Cuti diluluskan!');
    }

    public function delete(Leave $leave)
    {
        DB::table('leaves')
            ->where('id', $leave->id)
            ->update(['active' => 0, 'hr_approval' => 1]);

        return back()->with('success', 'Cuti dibatalkan!');
    }

    public function list()
    {
        return view('leaves.list', [
            'leaves' => Leave::with(['user','leave_type'])->orderBy('start', 'desc')->paginate(20),
        ]);
    }
}
