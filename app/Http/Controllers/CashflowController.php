<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\CashCategory;
use App\Models\Cashflow;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CashflowController extends Controller
{
    public function index()
    {
        return redirect("/cashflow/" . auth()->user()->branch_id);
    }

    public function view($branch)
    {
        return view('cashflows.index', [
            'branch' => Branch::find($branch),
            'categories' => CashCategory::get(),
            'cashflows' => Cashflow::with('category')->where('branch_id', $branch)->orderBy('created_at', 'desc')->orderBy('created_at', 'desc')->paginate(30),
        ]);
    }
    public function add($branch)
    {
        $attr = request()->validate([
            'category_id' => 'required|numeric|exists:cash_categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'reference' => 'required',
            'note' => 'nullable',
        ]);
        $attr['amount'] = $attr['amount'] * 100;
        $attr['branch_id'] = $branch;


        $type = CashCategory::find($attr['category_id']);
        if ($type->in == 1) {
            cash_in($attr);
        }
        if ($type->in == 0) {
            cash_out($attr);
        }

        return back()->with('success', 'Aliran tunai direkod');
    }

    public function delete(Cashflow $cashflow)
    {
        $cashflow->delete();
        if ($cashflow->category->in == 1){
            DB::table('branches')->where('id', $cashflow->branch_id)->decrement('cash_current',$cashflow->amount);
        }
        else {
            DB::table('branches')->where('id', $cashflow->branch_id)->increment('cash_current',$cashflow->amount);
        }
        return back()->with('success', 'Aliran tunai dipadam');
    }
}
