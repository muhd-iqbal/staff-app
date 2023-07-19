<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class SMAController extends Controller
{
    public function redir()
    {
        return redirect("/orders/old/" . auth()->user()->branch->shortname);
    }

    public function index($branch)
    {
        switch ($branch) {
            case "gurun":
                $data = DB::table('sma_gurun_sales')->select('*', 'sma_gurun_sales.id as oid')
                    ->leftJoin('sma_gurun_companies', 'sma_gurun_companies.id', '=', 'sma_gurun_sales.customer_id');
                break;
            case "guar":
                $data = DB::table('sma_guar_sales')->select('*', 'sma_guar_sales.id as oid')
                    ->leftJoin('sma_guar_companies', 'sma_guar_companies.id', '=', 'sma_guar_sales.customer_id');
                break;
            default:
                redirect("/");
                break;
        }

        if (request('search')) {
            $data->where('reference_no', 'like', '%' . request('search') . '%')->orWhere('customer', 'like', '%' . request('search') . '%')->orWhere('phone', 'like', '%' . request('search') . '%')->orWhere('date', 'like', '%' . request('search') . '%');
        }

        return view('sma.index', [
            'orders' => $data->orderBy('oid', 'DESC')->paginate(50),
            'branch' => $branch,
        ]);
    }

    public function view($branch, $id)
    {
        switch ($branch) {
            case "gurun":
                $sale = DB::table('sma_gurun_sales');
                $item = DB::table('sma_gurun_sale_items');
                $cust = DB::table('sma_gurun_companies');
                $pays = DB::table('sma_gurun_payments');
                break;
            case "guar":
                $sale = DB::table('sma_guar_sales');
                $item = DB::table('sma_guar_sale_items');
                $cust = DB::table('sma_guar_companies');
                $pays = DB::table('sma_guar_payments');
                break;
            default:
                redirect("/");
                break;
        }
        // return $pays->where('sale_id', $id)->get();
        $sale = $sale->where('id', $id)->get()->all();
        return view('sma.view', [
            'order' => $sale,
            'items' => $item->where('sale_id', $id)->get(),
            'cust' => $cust->where('id', $sale[0]->customer_id)->get()->all(),
            'pays' => $pays->where('sale_id', $id)->get()->all(),
            'branch' => $branch,
        ]);
    }
}
