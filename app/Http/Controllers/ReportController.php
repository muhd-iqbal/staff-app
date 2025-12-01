<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    //page yang agak serabut. maafin gue..

    public function index()
    {
        return redirect('/reports/' . date('Y'));
    }

    /**
     * Helper to build daily sales collection for a given date range.
     *
     * For current POS data we use the orders table (Order model) and divide grand_total by 100
     * (to match existing yearly() behavior which divides totals by 100).
     *
     * For old POS data we query the legacy sales tables (sma_gurun_sales / sma_guar_sales)
     * and return totals as-is (to match existing old_yearly() usage).
     *
     * Returns a collection of objects with ->date (YYYY-MM-DD) and ->total (numeric).
     */
    private function buildDailySalesCollection(?string $start, ?string $end, $branch = null, bool $old = false)
    {
        $daily = collect();

        if (! $start && ! $end) {
            return $daily;
        }

        // Normalize dates: if only one provided, use it for both
        if ($start && ! $end) {
            $end = $start;
        } elseif ($end && ! $start) {
            $start = $end;
        }

        // Basic normalization to YYYY-MM-DD
        try {
            $sd = date('Y-m-d', strtotime($start));
            $ed = date('Y-m-d', strtotime($end));
        } catch (\Throwable $e) {
            return $daily;
        }

        if (! $sd || ! $ed) {
            return $daily;
        }

        if (! $old) {
            // Current POS: use orders table
            $query = Order::selectRaw('DATE(date) as date, COALESCE(SUM(grand_total),0) as total')
                ->whereBetween(DB::raw('DATE(date)'), [$sd, $ed]);

            if ($branch) {
                $query->where('branch_id', $branch);
            }

            $daily = $query->groupBy(DB::raw('DATE(date)'))
                ->orderBy(DB::raw('DATE(date)'))
                ->get()
                ->map(function ($r) {
                    // existing yearly() divides totals by 100 when building monthly array
                    $r->total = $r->total / 100;
                    return $r;
                });
        } else {
            // Old POS: depending on branch we either query a specific table or union both
            // For old combined data (no branch) we union the two legacy tables
            if (! $branch) {
                $posStart = config('app.pos_start') . ' 00:00:00';

                $sql = "
                    SELECT DATE(date) as date, SUM(grand_total) as total
                    FROM (
                        SELECT * FROM sma_gurun_sales
                        UNION ALL
                        SELECT * FROM sma_guar_sales
                    ) s
                    WHERE DATE(date) >= ? AND DATE(date) <= ? AND date < ?
                    GROUP BY DATE(date)
                    ORDER BY DATE(date)
                ";

                $rows = DB::select($sql, [$sd, $ed, $posStart]);
                $daily = collect($rows);
            } else {
                // branch-specific old tables (old_branch_yearly maps '1' and '2' to different tables)
                $table = $branch === '1' ? 'sma_gurun_sales' : ($branch === '2' ? 'sma_guar_sales' : null);

                if ($table) {
                    $posStart = config('app.pos_start') . ' 00:00:00';
                    $sql = "
                        SELECT DATE(date) as date, SUM(grand_total) as total
                        FROM {$table}
                        WHERE DATE(date) >= ? AND DATE(date) <= ? AND date < ?
                        GROUP BY DATE(date)
                        ORDER BY DATE(date)
                    ";
                    $rows = DB::select($sql, [$sd, $ed, $posStart]);
                    $daily = collect($rows);
                } else {
                    $daily = collect();
                }
            }
        }

        return $daily;
    }

    public function yearly($y)
    {
        $dbData = Order::select(
            // DB::raw('year(date) as year'),
            DB::raw('month(date) as month'),
            DB::raw('sum(due) as dues'),
            DB::raw('sum(discount) as discounts'),
            DB::raw('sum(shipping) as shippings'),
            DB::raw('sum(grand_total) as totals'),
        )
            ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
            ->where(DB::raw('year(date)'), '=', $y)
            ->groupBy('month')
            ->get();

        // build monthly sales (divide by 100 to match existing behavior)
        for ($month = 1; $month <= 12; $month++) {
            $sales[month_name($month)] = (optional($dbData->first(fn ($row) => $row->month == $month))->totals) / 100;
        }

        // Build dailySales if date range provided (current POS)
        $start = request()->query('start_date');
        $end = request()->query('end_date');
        $dailySales = $this->buildDailySalesCollection($start, $end, null, false);

        return view('reports.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
            'current' => 1,
            'dailySales' => $dailySales,
        ]);
    }

    public function branch_yearly($y, $branch)
    {
        $dbData = Order::select(
            // DB::raw('year(date) as year'),
            DB::raw('month(date) as month'),
            DB::raw('sum(due) as dues'),
            DB::raw('sum(discount) as discounts'),
            DB::raw('sum(shipping) as shippings'),
            DB::raw('sum(grand_total) as totals'),
        )
            ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
            ->where(DB::raw('year(date)'), '=', $y)
            ->where('branch_id', '=', $branch)
            ->groupBy('month')
            ->get();

        for ($month = 1; $month <= 12; $month++) {
            $sales[month_name($month)] = (optional($dbData->first(fn ($row) => $row->month == $month))->totals) / 100;
        }

        // Build dailySales for this branch if date range provided
        $start = request()->query('start_date');
        $end = request()->query('end_date');
        $dailySales = $this->buildDailySalesCollection($start, $end, $branch, false);

        return view('reports.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
            'curr_branch' => Branch::find($branch),
            'current' => 1,
            'dailySales' => $dailySales,
        ]);
    }

    public function old_index()
    {
        return redirect('/old-reports/' . date('Y'));
    }

    public function old_yearly($y)
    {

        $summary =  DB::select("SELECT month(date) as month, sum(total) as totals, sum(total_discount) as discounts, sum(shipping) as shippings, sum(grand_total) as grand_totals
        FROM ( SELECT * FROM sma_gurun_sales UNION ALL SELECT * FROM sma_guar_sales ) s
        WHERE date > '$y-01-01 00:00:00' AND date < '$y-12-31 23:59:59' AND date < '" . config('app.pos_start') . " 00:00:00'
        GROUP BY month");

        $summary = collect($summary);

        for ($month = 1; $month <= 12; $month++) {
            $sales[month_name($month)] = (optional($summary->first(fn ($row) => $row->month == $month))->grand_totals);
        }

        // Build dailySales from old POS data if date range provided
        $start = request()->query('start_date');
        $end = request()->query('end_date');
        $dailySales = $this->buildDailySalesCollection($start, $end, null, true);

        return view('reports.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
            'current' => 0,
            'dailySales' => $dailySales,
        ]);
    }

    public function old_branch_yearly($y, $branch)
    {
        switch ($branch) {
            case '1':
                $summary = DB::table('sma_gurun_sales')
                    ->select(
                        DB::raw('month(date) as month'),
                        DB::raw('sum(total_discount) as discounts'),
                        DB::raw('sum(shipping) as shippings'),
                        DB::raw('sum(total) as totals'),
                        DB::raw('sum(grand_total) as grand_totals'),
                    )
                    ->where('date', '>', $y . '-01-01 00:00:00')
                    ->where('date', '<', $y . '-12-31 23:59:59')
                    ->where('date', '<', config('app.pos_start') . ' 00:00:00')
                    ->groupBy(DB::raw('month'))
                    ->get();
                break;
            case '2':
                $summary = DB::table('sma_guar_sales')
                    ->select(
                        DB::raw('month(date) as month'),
                        DB::raw('sum(total_discount) as discounts'),
                        DB::raw('sum(shipping) as shippings'),
                        DB::raw('sum(total) as totals'),
                        DB::raw('sum(grand_total) as grand_totals'),
                    )
                    ->where('date', '>', $y . '-01-01 00:00:00')
                    ->where('date', '<', $y . '-12-31 23:59:59')
                    ->where('date', '<', config('app.pos_start') . ' 00:00:00')
                    ->groupBy(DB::raw('month'))
                    ->get();
                break;

            default:
                return redirect('/old-reports/' . date("Y"));
                break;
        }

        for ($month = 1; $month <= 12; $month++) {
            $sales[month_name($month)] = (optional($summary->first(fn ($row) => $row->month == $month))->grand_totals);
        }

        // Build dailySales for old branch if date range provided
        $start = request()->query('start_date');
        $end = request()->query('end_date');
        $dailySales = $this->buildDailySalesCollection($start, $end, $branch, true);

        return view('reports.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
            'curr_branch' => Branch::find($branch),
            'current' => 0,
            'dailySales' => $dailySales,
        ]);
    }
}
