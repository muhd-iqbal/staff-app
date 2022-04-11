<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Cashflow;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index($order)
    {
        return view('orders.payment', [
            'order' => Order::find($order),
            'payments' => Payment::where('order_id', $order)->get(),
            'branches' => Branch::get(),
            'payment_method' => $this->payment_method,
        ]);
    }

    public function insert($order)
    {
        //validate data
        $attributes = request()->validate([
            'amount' => 'required|numeric',
            'payment_method' => ['required', Rule::in(array_keys($this->payment_method))],
            'reference' => 'nullable|alpha_num|max:50',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i:s',
            'branch_id' => 'required|exists:branches,id',
            'attachment' => 'mimes:jpeg,png,svg,pdf|max:1024',
        ]);

        if (isset($attributes['attachment'])) {
            $attributes['attachment'] = request()->file('attachment')->store('pay-attachments');
        }
        //modify data to match database
        $attributes['order_id'] = $order;
        $attributes['time'] = $attributes['date'] . " " . $attributes['time'];
        $attributes['amount'] = $attributes['amount'] * 100;
        $attributes['user_id'] = auth()->id();
        unset($attributes['date']);

        //create the payment and modify order table
        $insert = Payment::create($attributes);
        if($attributes['payment_method']=='tunai'){

            cash_in([
                'date' => substr($attributes['time'],0,10),
                'branch_id' => $attributes['branch_id'],
                'category_id' => 1,
                'reference' => 'ID Bayaran: '.payment_num($insert->id),
                'amount' => $attributes['amount'],
                'note' => 'Bayaran untuk ' . order_num($attributes['order_id']),
                'payment_id' => $insert->id,
            ]);
        }
        DB::table('orders')->where('id', $order)->increment('paid', $attributes['amount']);
        DB::table('orders')->where('id', $order)->decrement('due', $attributes['amount']);

        return back()->with('success', 'Pembayaran direkod');
    }

    public function destroy(Order $order, Payment $payment)
    {
        DB::table('orders')->where('id', $order->id)->decrement('paid', $payment->amount);
        order_adjustment($order->id);
        if($payment->payment_method == 'tunai'){
            DB::table('cashflows')->where('payment_id', $payment->id)->delete();
            DB::table('branches')->where('id',$payment->branch_id)->decrement('cash_current', $payment->amount);
        }

        $payment->delete();
        return back()->with('success', 'Pembayaran '. payment_num($payment->id) .' dipadam');
    }
}
