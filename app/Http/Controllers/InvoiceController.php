<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function invoice($order)
    {
        return view('invoices.invoice', [
            'order' => Order::find($order),
            'measurements' => $this->measurement,            // 'branch' => Branch::get(),
        ]);
    }

    public function edit_invoice(Order $order)
    {
        $attributes = request()->validate([
            'foot_note' => 'nullable'
        ]);

        $order->update($attributes);

        return back()->with('success', 'Berjaya dikemakini');
    }

    public function do($order) //delivery order
    {
        return view('invoices.delivery_order', [
            'order' => Order::with('order_item')->find($order),
            'measurements' => $this->measurement,
        ]);
    }

    public function edit_do(Order $order)
    {
        $attributes = request()->validate([
            'delivery_tracking' => 'nullable',
            'delivery_status' => 'required|boolean',
        ]);

        $order->update($attributes);

        return back()->with('success', 'Berjaya dikemakini');
    }

    public function po(Order $order) //purchase order
    {
        return view('invoices.purchase_order', [
            'order' => $order,
            'measurements' => $this->measurement,
        ]);
    }
}
