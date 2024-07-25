<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ChequeReports;
use App\Models\ChequeReportsList;
use App\Models\User;
use Illuminate\Http\Request;

class ChequeReportController extends Controller
{
    public function index()
    {
        return view('pay_vouchers.index', [
            'vouchers' => ChequeReports::orderBy('created_at', 'DESC')->paginate(20),
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

        $cheque = ChequeReports::create($attr);

        return redirect('/cheque-reports/' . $cheque->id)->with('success', 'Baucer dibuat.');
    }

    public function view(ChequeReports $cheque)
    {
        return view('pay_vouchers.view', [
            'branch' => Branch::find(1),
            'cheque' => $cheque,
            'voucher_lists' => ChequeReportsList::where('voucher_id', $cheque->id)->get(),
            'approved_by' => User::where('id', $cheque->approved_by)->first(),
            'prepared_by' => User::where('id', $cheque->prepared_by)->first(),
        ]);
    }

    public function edit(ChequeReports $cheque)
    {
        if ($cheque->is_received) {
            return back()->with('forbidden', 'Baucer yang telah dibayar tidak boleh diubah.');
        } else {

            return view('pay_vouchers.edit', [
                'cheque' => $cheque,
            ]);
        }
    }

    public function update(ChequeReports $cheque)
    {
        if ($cheque->is_received) {
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

            $cheque->update($attr);

            return redirect('/cheque-reports/' . $cheque->id)->with('success', 'Baucer dikemaskini.');
        }
    }

    public function approve(ChequeReports $cheque)
    {
        if ($cheque->is_received) {
            return back()->with('forbidden', 'Baucer yang telah dibayar tidak boleh diubah.');
        } else {

            $cheque->update([
                'is_approved' => 1,
                'approved_by' => auth()->id(),
                'approved_date' => date("Y-m-d"),
            ]);

            return back()->with('success', 'Payment cheque approved');
        }
    }

    public function paid(ChequeReports $cheque)
    {
        if ($cheque->is_received) {
            return back()->with('forbidden', 'Baucer yang telah dibayar tidak boleh diubah.');
        } else {

            // $attr = request()->validate([
            //     'received_date' => 'required|date'
            // ]);
            $attr['received_date'] = date("Y-m-d");
            $attr['is_received'] = 1;
            $cheque->update($attr);

            return back()->with('success', 'Payment cheque mark received');
        }
    }

    public function img(ChequeReports $cheque, Request $request)
    {
        $request->validate(['attachment' => 'required|file']);

        $attr['attachment'] = request()->file('attachment')->store('attachments');

        $cheque->update($attr);

        return back()->with('success', 'Lampiran dimuatnaik');
    }
}
