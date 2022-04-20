<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\PaymentVoucher;
use App\Models\PaymentVoucherList;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentVoucherController extends Controller
{
    public function index()
    {
        return view('pay_vouchers.index', [
            'vouchers' => PaymentVoucher::orderBy('created_at', 'DESC')->paginate(2),
        ]);
    }

    public function create()
    {
        $attr = request()->validate([
            'payee_name' => 'required|max:255',
            'payee_phone' => 'required|numeric',
            'payee_bank' => 'nullable|max:100',
            'payee_acc_no' => 'nullable|max:100',
            'payment_method' => 'nullable',
            'due_date' => 'nullable|date',
            'remarks' => 'nullable',
        ]);
        $attr['prepared_by'] = auth()->id();
        $attr['prepared_date'] = date("Y-m-d");

        $voucher = PaymentVoucher::create($attr);

        return redirect('/payment-vouchers/' . $voucher->id)->with('success', 'Baucer dibuat.');
    }

    public function view(PaymentVoucher $voucher)
    {
        return view('pay_vouchers.view', [
            'branch' => Branch::find(1),
            'voucher' => $voucher,
            'voucher_lists' => PaymentVoucherList::where('voucher_id', $voucher->id)->get(),
            'approved_by' => User::where('id', $voucher->approved_by)->first(),
            'prepared_by' => User::where('id', $voucher->prepared_by)->first(),
        ]);
    }

    public function edit(PaymentVoucher $voucher)
    {
        if ($voucher->is_received) {
            return back()->with('forbidden', 'Baucer yang telah dibayar tidak boleh diubah.');
        } else {

            return view('pay_vouchers.edit', [
                'voucher' => $voucher,
            ]);
        }
    }

    public function update(PaymentVoucher $voucher)
    {
        if ($voucher->is_received) {
            return back()->with('forbidden', 'Baucer yang telah dibayar tidak boleh diubah.');
        } else {

            $attr = request()->validate([
                'payee_name' => 'required|max:255',
                'payee_phone' => 'required|numeric',
                'payee_bank' => 'nullable|max:100',
                'payee_acc_no' => 'nullable|max:100',
                'payment_method' => 'nullable',
                'due_date' => 'nullable|date',
                'remarks' => 'nullable',
            ]);
            $attr['prepared_by'] = auth()->id();
            // $attr['prepared_date'] = date("Y-m-d");

            $voucher->update($attr);

            return redirect('/payment-vouchers/' . $voucher->id)->with('success', 'Baucer dikemaskini.');
        }
    }

    public function approve(PaymentVoucher $voucher)
    {
        if ($voucher->is_received) {
            return back()->with('forbidden', 'Baucer yang telah dibayar tidak boleh diubah.');
        } else {

            $voucher->update([
                'is_approved' => 1,
                'approved_by' => auth()->id(),
                'approved_date' => date("Y-m-d"),
            ]);

            return back()->with('success', 'Payment voucher approved');
        }
    }

    public function paid(PaymentVoucher $voucher)
    {
        if ($voucher->is_received) {
            return back()->with('forbidden', 'Baucer yang telah dibayar tidak boleh diubah.');
        } else {

            // $attr = request()->validate([
            //     'received_date' => 'required|date'
            // ]);
            $attr['received_date'] = date("Y-m-d");
            $attr['is_received'] = 1;
            $voucher->update($attr);

            return back()->with('success', 'Payment voucher mark received');
        }
    }
}
