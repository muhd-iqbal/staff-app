<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffReportController extends Controller
{
    public function index()
    {
        return redirect('/staff-reports/' . date('Y'));
    }

    public function yearly($y, Request $request)
{
    $month = $request->query('month'); // get month from query

    $query = Order::select(DB::raw('month(date) as month'))
        ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
        ->where(DB::raw('year(date)'), '=', $y);

    if ($month) {
        $query->where(DB::raw('month(date)'), '=', $month);
    }

    $dbData = $query->groupBy('month')->get();

    // ...rest of your code
}
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

    public function old_index()
    {
        return redirect('/staff-old-reports/' . date('Y'));
    }

    public function old_yearly($y)
    {
        $summary = DB::table('order_items')
        ->select(DB::raw('month(date) as month'), DB::raw('sum(order_items) as totals')) //kena ubah
        ->where('date', '>', $y . '-01-01 00:00:00')
        ->where('date', '<', $y . '-12-31 23:59:59')
        ->where('date', '<', config('app.pos_start') . ' 00:00:00')
        ->groupBy('month')
        ->get();

        $summary = collect($summary);

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
            'current' => 0,
        ]);
    }
}

