<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'order_id' => 'nullable|starts_with:' . env('ORDER_PREFIX'),
            'product' => 'required|min:5',
            'size' => 'required|max:50',
            'quantity' => 'required|integer|min:1',
            'branch_id' => 'required|exists:branches,id',
            'remarks' => 'nullable',
            'measurement' => ['required', Rule::in(array_keys($this->measurement))],
            // 'image' => 'nullable|image',
        ]);

        $insert = [
            'product' => $attr['product'],
            'size' => $attr['size'],
            'quantity' => $attr['quantity'],
            'remarks' => $attr['remarks'],
            'price' => 0,
            'total' => 0,
            'measurement' => $attr['measurement'],
        ];

        if (request('order_id') != null) {
            $order_id = (int)ltrim($attr['order_id'], env('ORDER_PREFIX'));

            $check_if_same_user = Order::where('customer_id', session('agent_id'))
                ->where('id', $order_id)->first();

            if ($check_if_same_user) {
                $insert['order_id'] =  $order_id;
                OrderItem::create($insert);
            } else {
                return back()->with('forbidden', 'No Order dimasukkan bukan kepunyaan anda.');
            }
        } else {
            $new_order = Order::create([
                'customer_id' => session('agent_id'),
                'date' => date("Y-m-d"),
                'method' => 'walkin',
                'branch_id' => $attr['branch_id'],
                'user_id' => 1,
            ]);
            $insert['order_id'] =  $new_order->id;
            OrderItem::create($insert);
        }

        return redirect("/agent")->with('success', 'Order Berjaya Dibuat');
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
