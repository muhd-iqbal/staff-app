<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherList;
use Illuminate\Support\Facades\DB;

class PaymentVoucherListController extends Controller
{
    public function create(PaymentVoucher $voucher)
    {
        if ($voucher->is_received) {
            return back()->with('forbidden', 'Baucer yang telah dibayar tidak boleh diubah.');
        } else {

            $attr = request()->validate([
                'title' => 'required|max:255',
                'amount' => 'required|numeric|min:0'
            ]);

            $attr['voucher_id'] = $voucher->id;
            $attr['amount'] = $attr['amount'] * 100;

            PaymentVoucherList::create($attr);

            DB::table('payment_vouchers')->where('id', $voucher->id)->increment('total', $attr['amount']);

            return back()->with('success', 'Item Ditambah');
        }
    }

    public function delete(PaymentVoucher $voucher, PaymentVoucherList $list)
    {
        if ($voucher->is_received) {
            return back()->with('forbidden', 'Baucer yang telah dibayar tidak boleh diubah.');
        } else {

            DB::table('payment_vouchers')->where('id', $voucher->id)->decrement('total', $list->amount);

            $list->delete();

            return back()->with('success', 'Item Dipadam');
        }
    }
}
