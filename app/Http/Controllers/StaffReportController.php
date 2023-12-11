<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffReportController extends Controller
{
    public function index()
    {
        return redirect('/staff-reports/' . date('Y'));
    }

    public function yearly($y)
    {
        $dbData = Order::select(
            DB::raw('users as user_id'),
        )
            ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
            ->where(DB::raw('year(date)'), '=', $y)
            ->groupBy('user_id')
            ->get();

        //$orders = [];

        $users = User::with('order_item')->where('position_id', '<>', 1)->where('active', true)->get();

        foreach ($users as $user) {
            $userId = $user->id;
            $orders[$user->name] = optional($dbData->first(fn ($row) => $row->user_id == $userId))->totals;
        }

        return view('staff_report.index', [
            'order' => $orders,
            'users' => $user,
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:'.date("Y"),
            'current' => 1,
        ]);
    }

    public function branch_yearly($y, $month)
    {
        $dbData = Order::select(
            DB::raw('users as user_id'),
        )
            ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
            ->where(DB::raw('year(date)'), '=', $y)
            ->where('user_id', '=', $user)
            ->groupBy('user_id')
            ->get();

        //$orders = [];

        $users = User::with('order_item')->where('position_id', '<>', 1)->where('active', true)->get();

        foreach ($users as $user) {
            $userId = $user->id;
            $orders[$user->name] = optional($dbData->first(fn ($row) => $row->user_id == $userId))->totals;
        }

        return view('staff_report.index', [
            'order' => $orders,
            'users' => $user,
            'curr_user' => User::find($user), //tukar kepada month ???
            'current' => 1,
        ]);
    }

    public function old_index()
    {
        return redirect('/staff-old-reports/' . date('Y'));
    }

    public function old_yearly($y)
    {
        $dbData = Order::select(
            DB::raw('users as user_id'),
        )
            ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
            ->where(DB::raw('year(date)'), '=', $y)
            ->groupBy('user_id')
            ->get();

        //$orders = [];

        $users = User::with('order_item')->where('position_id', '<>', 1)->where('active', true)->get();

        foreach ($users as $user) {
            $userId = $user->id;
            $orders[$user->name] = optional($dbData->first(fn ($row) => $row->user_id == $userId))->totals;
        }

        return view('staff_report.index', [
            'order' => $orders,
            'users' => $user,
            'current' => 1,
        ]);
    }


    public function sortByMonth()
    {
        $records = Order::orderByRaw('MONTH(created_at)')->get();
        return view('staff_report.index', compact('records'));
    }

    public function old_branch_yearly($y, $month)
    {
        $dbData = Order::select(
            DB::raw('users as user_id'),
        )
            ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
            ->where(DB::raw('year(date)'), '=', $y)
            ->where('user_id', '=', $user)
            ->groupBy('user_id')
            ->get();

        //$orders = [];

        $users = User::with('order_item')->where('position_id', '<>', 1)->where('active', true)->get();

        foreach ($users as $user) {
            $userId = $user->id;
            $orders[$user->name] = optional($dbData->first(fn ($row) => $row->user_id == $userId))->totals;
        }

        return view('staff_report.index', [
            'order' => $orders,
            'users' => $user,
            'curr_user' => User::find($user), //
            'current' => 1,
        ]);
    }
}
