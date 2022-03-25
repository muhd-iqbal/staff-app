<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index($order)
    {
        return view('invoices.view', [
            'order' => Order::find($order),
            // 'branch' => Branch::get(),
        ]);
    }
}
