<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class AgentOrderController extends Controller
{
    public function index()
    {
        return view('agents.add', [
            'measurements' => $this->measurement,
            'branches' => Branch::all(),
        ]);
    }

    public function create()
    {
        $attr = request()->validate([
            'product' => 'required|min:5',
            'size' => 'required|max:50',
            'quantity' => 'required|integer|min:1',
            'branch_id' => 'required|exists:branches,id',
            'remarks' => 'nullable'
        ]);

        $check_if_exist = Order::where('customer_id', session('agent_id'))
            ->where('date', '=', date("Y-m-d"))->where('branch_id', $attr['branch_id'])->first();


        if ($check_if_exist === null) {
            $new_order = Order::create([
                'customer_id' => session('agent_id'),
                'date' => date("Y-m-d"),
                'method' => 'walkin',
                'branch_id' => $attr['branch_id'],
                'user_id' => 1,
            ]);

            OrderItem::create([
                'order_id' => $new_order->id,
                'product' => $attr['product'],
                'size' => $attr['size'],
                'quantity' => $attr['quantity'],
                'remarks' => $attr['remarks'],
                'price' => 0,
                'total' => 0,
            ]);
        } else {
            OrderItem::create([
                'order_id' => $check_if_exist->id,
                'product' => $attr['product'],
                'size' => $attr['size'],
                'quantity' => $attr['quantity'],
                'remarks' => $attr['remarks'],
                'price' => 0,
                'total' => 0,
            ]);
        }
        return redirect("/agent")->with('success', 'Order Berjaya Dibuat');
        // return redirect("/agent/order/$new_order->id")->with('success', 'Order Berjaya Dibuat');
    }

    public function view(Order $order)
    {
        $items = OrderItem::where('order_id', $order->id)->get();

        return view('agents.viewitem', [
            'order' => $order,
            'items' => $items,
            'agent' => Customer::where('id', session('agent_id'))->first(),
        ]);
    }

}
