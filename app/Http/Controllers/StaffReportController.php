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

        // Use created_at instead of date (replace created_at with your actual date column if different)
        $query = Order::select(
            DB::raw('month(created_at) as month'),
            DB::raw('count(*) as totals')
        )
        ->whereDate('created_at', '>=', config('app.pos_start'))
        ->whereYear('created_at', '=', $y);

        if ($month) {
            $query->whereMonth('created_at', '=', $month);
        }

        $dbData = $query->groupBy('month')->get();

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = (optional($dbData->first(fn ($row) => $row->month == $m))->totals) ?? 0;
        }

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
        // Use created_at instead of date (replace created_at with your actual column if different)
        $summary = DB::table('order_items')
            ->select(DB::raw('month(created_at) as month'), DB::raw('sum(order_items) as totals'))
            ->where('created_at', '>', $y . '-01-01 00:00:00')
            ->where('created_at', '<', $y . '-12-31 23:59:59')
            ->where('created_at', '<', config('app.pos_start') . ' 00:00:00')
            ->groupBy('month')
            ->get();

        $summary = collect($summary);

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = (optional($summary->first(fn ($row) => $row->month == $m))->totals) ?? 0;
        }

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
