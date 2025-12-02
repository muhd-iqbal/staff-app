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

        // Detect date column on the orders table (for monthly totals)
        $orderDateColumn = Schema::hasColumn('orders', 'created_at') ? 'created_at'
            : (Schema::hasColumn('orders', 'date') ? 'date' : null);

        // Build monthly totals for orders (chart)
        $query = Order::select(DB::raw("month($orderDateColumn) as month"), DB::raw('count(*) as totals'))
            ->whereYear($orderDateColumn, $y);

        if ($month) {
            $query->whereMonth($orderDateColumn, $month);
        }

        $dbData = $query->groupBy('month')->get()->keyBy('month');

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = optional($dbData->get($m))->totals ?? 0;
        }

        // Detect if order_items has a date column. If not, we will filter via order_item->order(date).
        $orderItemDateColumn = Schema::hasColumn('order_items', 'created_at') ? 'created_at'
            : (Schema::hasColumn('order_items', 'date') ? 'date' : null);

        // DEBUG: uncomment to verify what's detected
        // dd(['orderDateColumn' => $orderDateColumn, 'orderItemDateColumn' => $orderItemDateColumn, 'month' => $month, 'year' => $y]);

        // Build users query: apply the same date filter via order_items or via the parent order relationship
        $usersQuery = User::where('position_id', '<>', 1)
            ->where('active', true)
            ->whereHas('order_item', function ($q) use ($y, $month, $orderItemDateColumn, $orderDateColumn) {
                if ($orderItemDateColumn) {
                    // order_items table has its own date column
                    $q->whereYear($orderItemDateColumn, $y);
                    if ($month) $q->whereMonth($orderItemDateColumn, $month);
                } else {
                    // filter order_items by their parent order's date
                    $q->whereHas('order', function ($qq) use ($y, $month, $orderDateColumn) {
                        $qq->whereYear($orderDateColumn, $y);
                        if ($month) $qq->whereMonth($orderDateColumn, $month);
                    });
                }
            });

        // withCount must apply the same logic so order_item_count is the filtered count
        $usersQuery = $usersQuery->withCount(['order_item as order_item_count' => function ($q) use ($y, $month, $orderItemDateColumn, $orderDateColumn) {
            if ($orderItemDateColumn) {
                $q->whereYear($orderItemDateColumn, $y);
                if ($month) $q->whereMonth($orderItemDateColumn, $month);
            } else {
                $q->whereHas('order', function ($qq) use ($y, $month, $orderDateColumn) {
                    $qq->whereYear($orderDateColumn, $y);
                    if ($month) $qq->whereMonth($orderDateColumn, $month);
                });
            }
        }]);

        // Get results
        $users = $usersQuery->get();

        // Optional debug to inspect returned counts:
        // dd($users->map(fn($u) => [$u->id, $u->name, $u->order_item_count]));

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

        // Detect date column on order_items or fallback to orders
        $orderItemDateColumn = Schema::hasColumn('order_items', 'created_at') ? 'created_at'
            : (Schema::hasColumn('order_items', 'date') ? 'date' : null);

        $orderDateColumn = Schema::hasColumn('orders', 'created_at') ? 'created_at'
            : (Schema::hasColumn('orders', 'date') ? 'date' : null);

        // Build monthly totals for old-year: count of order_items by month (use order_items date if present,
        // otherwise aggregate by parent order date)
        if ($orderItemDateColumn) {
            $summary = DB::table('order_items')
                ->select(DB::raw("month($orderItemDateColumn) as month"), DB::raw('count(*) as totals'))
                ->whereYear($orderItemDateColumn, $y);
            if ($month) $summary->whereMonth($orderItemDateColumn, $month);
            $summary = $summary->groupBy('month')->get()->keyBy('month');
        } else {
            // Aggregate by orders table if order_items has no date
            $summary = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->select(DB::raw("month($orderDateColumn) as month"), DB::raw('count(order_items.id) as totals'))
                ->whereYear("orders.$orderDateColumn", $y);
            if ($month) $summary->whereMonth("orders.$orderDateColumn", $month);
            $summary = $summary->groupBy('month')->get()->keyBy('month');
        }

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = optional($summary->get($m))->totals ?? 0;
        }

        // Build users with filtered order_item_count (same logic as above)
        $usersQuery = User::where('position_id', '<>', 1)
            ->where('active', true)
            ->whereHas('order_item', function ($q) use ($y, $month, $orderItemDateColumn, $orderDateColumn) {
                if ($orderItemDateColumn) {
                    $q->whereYear($orderItemDateColumn, $y);
                    if ($month) $q->whereMonth($orderItemDateColumn, $month);
                } else {
                    $q->whereHas('order', function ($qq) use ($y, $month, $orderDateColumn) {
                        $qq->whereYear($orderDateColumn, $y);
                        if ($month) $qq->whereMonth($orderDateColumn, $month);
                    });
                }
            });

        $usersQuery = $usersQuery->withCount(['order_item as order_item_count' => function ($q) use ($y, $month, $orderItemDateColumn, $orderDateColumn) {
            if ($orderItemDateColumn) {
                $q->whereYear($orderItemDateColumn, $y);
                if ($month) $q->whereMonth($orderItemDateColumn, $month);
            } else {
                $q->whereHas('order', function ($qq) use ($y, $month, $orderDateColumn) {
                    $qq->whereYear($orderDateColumn, $y);
                    if ($month) $qq->whereMonth($orderDateColumn, $month);
                });
            }
        }]);

        $users = $usersQuery->get();

        return view('staff_report.index', [
            'order' => $orders,
            'users' => $users,
            'current' => 0,
        ]);
    }
}
