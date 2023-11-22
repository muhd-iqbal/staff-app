<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffReportController extends Controller
{

    //page yang agak serabut. maafin gue..

    public function index()
    {
        $users = User::with(['position', 'department'])->orderBy('active', 'DESC')->orderBy('name')->paginate(10);
        return view('staff_report.index', ['users'=>$users]);

        return redirect('/staff-reports/' . date('Y'));
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

        // $data = [];

        // for ($year = 2022; $year <= now()->format('Y'); $year++) {
        for ($month = 1; $month <= 12; $month++) {
            $sales[month_name($month)] = (optional($dbData->first(fn ($row) => $row->month == $month))->totals) / 100;
            // $dues[month_name($month)] = (optional($dbData->first(fn($row) => $row->month == $month))->dues)/100;
            // 'year' => $year,
            // 'month' => $month,
            // 'totals' => optional($dbData->first(fn($row) => $row->month == $month && $row->year == $year))->totals,
            // 'dues' => optional($dbData->first(fn($row) => $row->month == $month && $row->year == $year))->dues,
        }
        // }

        return view('staff_report.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
            'current' => 1,
        ]);
    }
    public function show(User $user)
    {
        return view('staff.show', [
            'user' => $user,
            'departments' => Department::get(),
            'positions' => Position::get()
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

        // $data = [];

        // for ($year = 2022; $year <= now()->format('Y'); $year++) {
        for ($month = 1; $month <= 12; $month++) {
            $sales[month_name($month)] = (optional($dbData->first(fn ($row) => $row->month == $month))->totals) / 100;
        }
        // }
        return view('staff_report.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
            'curr_branch' => Branch::find($branch),
            'current' => 1,
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

        // $table1 = DB::table('sma_gurun_sales')
        //     ->select(
        //         // DB::raw('year(date) as year'),
        //         DB::raw('month(date) as month'),
        //         // DB::raw('sum(due) as dues'),
        //         DB::raw('sum(total_discount) as discounts'),
        //         DB::raw('sum(shipping) as shippings'),
        //         DB::raw('sum(total) as totals'),
        //         DB::raw('sum(grand_total) as grand_totals'),
        //     )
        //     ->where('date', '>', $y . '-01-01 00:00:00')
        //     ->where('date', '<', $y . '-12-31 23:59:59')
        //     ->groupBy(DB::raw('month'))
        // // ->get()
        // ;
        // return  $table2 = DB::table('sma_guar_sales')
        //     ->select(
        //         DB::raw('month(date) as month'),
        //         DB::raw('sum(total_discount) as discounts'),
        //         DB::raw('sum(shipping) as shippings'),
        //         DB::raw('sum(total) as totals'),
        //         DB::raw('sum(grand_total) as grand_totals'),
        //     )
        //     ->where('date', '>', $y . '-01-01 00:00:00')
        //     ->where('date', '<', $y . '-12-31 23:59:59')
        //     ->groupBy(DB::raw('month'))
        //     ->union($table1)
        //     ->get();

        // $table2 = DB::table('sma_guar_sales')->where('date', '>', $y . '-01-01 00:00:00')->where('date', '<', $y . '-12-31 23:59:59')->get();

        //     // DB::raw('year(date) as year'),
        //     DB::raw('month(date) as month'),
        //     DB::raw('sum(due) as dues'),
        //     DB::raw('sum(discount) as discounts'),
        //     DB::raw('sum(shipping) as shippings'),
        //     DB::raw('sum(grand_total) as totals'),
        // )
        //     ->where(DB::raw('date(date)'), '>=', config('app.pos_start'))
        //     ->where(DB::raw('year(date)'), '=', $y)
        //     ->groupBy('month')
        //     ->get();

        // $data = [];

        // for ($year = 2022; $year <= now()->format('Y'); $year++) {
        //     for ($month = 1; $month <= 12; $month++) {
        //         $sales[month_name($month)] = (optional($dbData->first(fn ($row) => $row->month == $month))->totals) / 100;
        //         // $dues[month_name($month)] = (optional($dbData->first(fn($row) => $row->month == $month))->dues)/100;
        //         // 'year' => $year,
        //         // 'month' => $month,
        //         // 'totals' => optional($dbData->first(fn($row) => $row->month == $month && $row->year == $year))->totals,
        //         // 'dues' => optional($dbData->first(fn($row) => $row->month == $month && $row->year == $year))->dues,
        //     }
        // }
        // return view('staff_report.index', [
        //     'sales' => $sales,
        //     'branches' => Branch::all(),
        // ]);

        for ($month = 1; $month <= 12; $month++) {
            $sales[month_name($month)] = (optional($summary->first(fn ($row) => $row->month == $month))->grand_totals);
        }

        return view('staff_report.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
            'current' => 0,
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

        return view('staff_report.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
            'curr_branch' => Branch::find($branch),
            'current' => 0,
        ]);
    }
}
