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
            DB::raw('month(date) as month'),
            DB::raw('count(id) as total_designs')
        )
            ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
            ->where(DB::raw('year(date)'), '=', $y)
            ->groupBy('month')
            ->get();

        $orders = [];

        foreach ($dbData as $row) {
            $orders[month_name($row->month)] = $row->total_designs;
        }

        $users = User::with(['order_item' => function ($query) use ($y) {
            $query->whereYear('date', $y);
        }])
            ->where('position_id', '<>', 1)
            ->where('active', true)
            ->has('order_item', '>', 0)
            ->get();

        return view('staff_report.index', [
            'order' => $orders,
            'users' => $users,
            'year' => $y,
        ]);
    }

    public function old_index()
    {
        return redirect('/staff-old-reports/' . date('Y'));
    }

    public function old_yearly($y)
    {
        $dbData = Order::select(
            // DB::raw('year(date) as year'),
            DB::raw('month(date) as month'),
        )
            ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
            ->where(DB::raw('year(date)'), '=', $y)
            ->groupBy('month')
            ->get();

        // $data = [];

        // for ($year = 2022; $year <= now()->format('Y'); $year++) {
        for ($month = 1; $month <= 12; $month++) {
            $orders[month_name($month)] = (optional($dbData->first(fn ($row) => $row->month == $month))->totals);
        }
        // }

        return view('staff_report.index', [
            'order' => $orders,
            'users' => User::with('order_item')
                ->where('position_id', '<>', 1)
                ->where('active', true)
                ->has('order_item', '>', 0)
                ->get(),
            'current' => 1,
        ]);
    }
}
