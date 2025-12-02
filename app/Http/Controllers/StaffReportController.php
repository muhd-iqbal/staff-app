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

        // Quick debug: uncomment to verify month is being passed
        // dd(['year' => $y, 'query' => $request->query()]);

        // Detect orders date column
        $orderDateColumn = Schema::hasColumn('orders', 'created_at') ? 'created_at'
            : (Schema::hasColumn('orders', 'date') ? 'date' : 'order_date');

        // Build monthly totals for the orders table (used for the monthly chart)
        $query = Order::select(
            DB::raw("month($orderDateColumn) as month"),
            DB::raw('count(*) as totals')
        )
        ->whereDate($orderDateColumn, '>=', config('app.pos_start'))
        ->whereYear($orderDateColumn, $y);

        if ($month) {
            $query->whereMonth($orderDateColumn, $month);
        }

        $dbData = $query->groupBy('month')->get();

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = (optional($dbData->first(fn ($row) => $row->month == $m))->totals) ?? 0;
        }

        // Detect date column on order_items (used to filter per-designer)
        $orderItemDateColumn = Schema::hasColumn('order_items', 'created_at') ? 'created_at'
            : (Schema::hasColumn('order_items', 'date') ? 'date' : 'order_date');

        // Optionally enable query logging for debugging:
        // DB::enableQueryLog();

        // Get users filtered by year/month and return a filtered count field `order_item_count`
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

        // Quick debug: uncomment to inspect the generated SQL queries and the counts
        // dd([
        //     'query_log' => DB::getQueryLog(),
        //     'users_counts' => $users->map(fn($u)=>[$u->id, $u->name, $u->order_item_count])
        // ]);

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

        // Detect date column on order_items
        $orderItemDateColumn = Schema::hasColumn('order_items', 'created_at') ? 'created_at'
            : (Schema::hasColumn('order_items', 'date') ? 'date' : 'order_date');

        // Build monthly totals for old orders (count of order_items rows)
        $summary = DB::table('order_items')
            ->select(DB::raw("month($orderItemDateColumn) as month"), DB::raw('count(*) as totals'))
            ->whereYear($orderItemDateColumn, $y);

        if ($month) {
            $summary->whereMonth($orderItemDateColumn, $month);
        }

        // exclude records after pos_start if your logic requires it:
        if (Schema::hasColumn('order_items', $orderItemDateColumn) && config('app.pos_start')) {
            $summary->where($orderItemDateColumn, '<', config('app.pos_start') . ' 00:00:00');
        }

        $summary = $summary->groupBy('month')->get()->keyBy('month');

        $orders = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders[month_name($m)] = (optional($summary->get($m))->totals) ?? 0;
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
