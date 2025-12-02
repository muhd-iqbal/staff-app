<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaffReportController extends Controller
{
    public function index()
    {
        return redirect('/staff-reports/' . date('Y'));
    }

    public function yearly($y, Request $request)
    {
        $month = $request->query('month'); // get month from query

        // Detect the date column used in the orders table (common candidates)
        $orderDateColumn = Schema::hasColumn('orders', 'created_at') ? 'created_at'
            : (Schema::hasColumn('orders', 'date') ? 'date' : 'order_date');

        $query = Order::select(
            DB::raw("month($orderDateColumn) as month"),
            DB::raw('count(*) as totals')
        )
        ->whereDate($orderDateColumn, '>=', config('app.pos_start'))
        ->whereYear($orderDateColumn, '=', $y);

        if ($month) {
            $query->whereMonth($orderDateColumn, '=', $month);
        }

        $dbData = $query->groupBy('month')->get();

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = (optional($dbData->first(fn ($row) => $row->month == $m))->totals) ?? 0;
        }

        // Detect the date column used in the order_items table (for filtering per-designer)
        $orderItemDateColumn = Schema::hasColumn('order_items', 'created_at') ? 'created_at'
            : (Schema::hasColumn('order_items', 'date') ? 'date' : 'order_date');

        // Get users who have order_item in the requested year/month,
        // and include a count (order_item_count) that is already filtered.
        $users = User::where('position_id', '<>', 1)
            ->where('active', true)
            ->whereHas('order_item', function ($q) use ($y, $month, $orderItemDateColumn) {
                $q->whereYear($orderItemDateColumn, $y);
                if ($month) {
                    $q->whereMonth($orderItemDateColumn, $month);
                }
            })
            ->withCount(['order_item as order_item_count' => function ($q) use ($y, $month, $orderItemDateColumn) {
                $q->whereYear($orderItemDateColumn, $y);
                if ($month) {
                    $q->whereMonth($orderItemDateColumn, $month);
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

    public function old_yearly($y, Request $request)
    {
        $month = $request->query('month');

        // Detect date column in order_items (common candidates)
        $orderItemDateColumn = Schema::hasColumn('order_items', 'created_at') ? 'created_at'
            : (Schema::hasColumn('order_items', 'date') ? 'date' : 'order_date');

        // Use count(*) (number of order_items rows per month) rather than summing a non-existent column.
        $summary = DB::table('order_items')
            ->select(DB::raw("month($orderItemDateColumn) as month"), DB::raw('count(*) as totals'))
            ->where($orderItemDateColumn, '>', $y . '-01-01 00:00:00')
            ->where($orderItemDateColumn, '<', $y . '-12-31 23:59:59')
            ->where($orderItemDateColumn, '<', config('app.pos_start') . ' 00:00:00')
            ->groupBy('month')
            ->get();

        $summary = collect($summary);

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = (optional($summary->first(fn ($row) => $row->month == $m))->totals) ?? 0;
        }

        // Also filter users by order_items in the given old-year (and optional month),
        // and return a pre-computed count field 'order_item_count'.
        $users = User::where('position_id', '<>', 1)
            ->where('active', true)
            ->whereHas('order_item', function ($q) use ($y, $month, $orderItemDateColumn) {
                $q->whereYear($orderItemDateColumn, $y);
                if ($month) {
                    $q->whereMonth($orderItemDateColumn, $month);
                }
            })
            ->withCount(['order_item as order_item_count' => function ($q) use ($y, $month, $orderItemDateColumn) {
                $q->whereYear($orderItemDateColumn, $y);
                if ($month) {
                    $q->whereMonth($orderItemDateColumn, $month);
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
