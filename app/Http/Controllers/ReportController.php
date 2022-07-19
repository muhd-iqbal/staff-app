<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return redirect('/reports/' . date('Y'));
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

        for ($year = 2022; $year <= now()->format('Y'); $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $sales[month_name($month)] = (optional($dbData->first(fn ($row) => $row->month == $month))->totals) / 100;
                // $dues[month_name($month)] = (optional($dbData->first(fn($row) => $row->month == $month))->dues)/100;
                // 'year' => $year,
                // 'month' => $month,
                // 'totals' => optional($dbData->first(fn($row) => $row->month == $month && $row->year == $year))->totals,
                // 'dues' => optional($dbData->first(fn($row) => $row->month == $month && $row->year == $year))->dues,
            }
        }
        return view('reports.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
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

        for ($year = 2022; $year <= now()->format('Y'); $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $sales[month_name($month)] = (optional($dbData->first(fn ($row) => $row->month == $month))->totals) / 100;
            }
        }
        return view('reports.index', [
            'sales' => $sales,
            'branches' => Branch::all(),
            'curr_branch' => Branch::find($branch),
        ]);
    }
}
