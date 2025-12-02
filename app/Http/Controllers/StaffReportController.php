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

        $query = Order::select(
            DB::raw('month(date) as month'),
            DB::raw('count(*) as totals')
        )
        ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
        ->where(DB::raw('year(date)'), '=', $y);

        if ($month) {
            $query->where(DB::raw('month(date)'), '=', $month);
        }

        $dbData = $query->groupBy('month')->get();

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = (optional($dbData->first(fn ($row) => $row->month == $m))->totals) ?? 0;
        }

        // Get users who have order_item in the requested year/month,
        // and include a count (order_item_count) that is already filtered.
        $users = User::where('position_id', '<>', 1)
            ->where('active', true)
            ->whereHas('order_item', function ($q) use ($y, $month) {
                $q->whereYear('date', $y);
                if ($month) {
                    $q->whereMonth('date', $month);
                }
            })
            ->withCount(['order_item as order_item_count' => function ($q) use ($y, $month) {
                $q->whereYear('date', $y);
                if ($month) {
                    $q->whereMonth('date', $month);
                }
            }])
            ->get();

        return view('staff_report.index', [
            'order' => $orders,
            'users' => $users,
            'current' => 1,
        ]);
    }

    public function old_index()
    {
        return redirect('/staff-old-reports/' . date('Y'));
    }

    // Accept Request here too so a month filter can be applied if you ever need it.
    public function old_yearly($y, Request $request)
    {
        $month = $request->query('month');

        $summary = DB::table('order_items')
            ->select(DB::raw('month(date) as month'), DB::raw('sum(order_items) as totals'))
            ->where('date', '>', $y . '-01-01 00:00:00')
            ->where('date', '<', $y . '-12-31 23:59:59')
            ->where('date', '<', config('app.pos_start') . ' 00:00:00')
            ->groupBy('month')
            ->get();

        $summary = collect($summary);

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = (optional($summary->first(fn ($row) => $row->month == $m))->totals) ?? 0;
        }

        // Filter users by order_items in the given old-year (and optional month),
        // and return a pre-computed count field 'order_item_count'.
        $users = User::where('position_id', '<>', 1)
            ->where('active', true)
            ->whereHas('order_item', function ($q) use ($y, $month) {
                $q->whereYear('date', $y);
                if ($month) {
                    $q->whereMonth('date', $month);
                }
            })
            ->withCount(['order_item as order_item_count' => function ($q) use ($y, $month) {
                $q->whereYear('date', $y);
                if ($month) {
                    $q->whereMonth('date', $month);
                }
            }])
            ->get();

        return view('staff_report.index', [
            'order' => $orders,
            'users' => $users,
            'current' => 0,
        ]);
    }
}
