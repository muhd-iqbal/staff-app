<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    protected $products = [
        'red'=>'Banner',
        'purple'=>'Streamer',
        'yellow'=>'Sticker',
        'green'=>'Business Card',
        'pink'=>'Flyers',
        'indigo'=>'Kad Kahwin',
        'gray'=>'Menu Book',
        'blue'=>'Lain-lain'
    ];

    public function index()
    {
        $orders = Order::orderBy('isDone', 'ASC')->orderBy('created_at', 'DESC');

        if(request('search')){
            $orders->where('customer_name', 'like', '%'.request('search').'%')->orWhere('customer_phone', 'like', '%'.request('search').'%');
        }

        return view('orders.index', [
            'orders' => $orders->paginate(10),
            // 'orders' => Order::orderBy('isDone', 'ASC')->orderBy('created_at', 'DESC')->paginate(10),
            // 'customers' => Customer::all()
        ]);
    }

    public function create()
    {
        return view('orders.create', [
            'products' => $this->products,
        ]);
    }

    public function insert()
    {
        $attributes = request()->validate([
            'customer_name' => 'required|min:3|max:255',
            'customer_phone' => 'min:10|max:11',
            'date' => 'required|date',
            'dateline' => 'nullable|date',
            'method' => ['required', Rule::in(['walkin', 'online'])],
            'location' => ['required', Rule::in(['gurun', 'guar'])],
            // 'product' => 'required|array',
            // 'remarks' => 'required',
        ]);

        // $attributes['product'] = implode(',', request('product'));

        $insert = Order::create($attributes);

        return redirect('/orders/view/'.$insert->id)->with('success', 'Order berjaya dibuat.');
    }

    public function view(Order $order)
    {
        $lists = OrderItem::with('user')->where('order_id', $order->id)->get();

        return view('orders.view', [
            'order' => $order,
            'lists' => $lists,
        ]);
    }

    public function update_done(Order $order)
    {
        $attributes['isDone'] = 1;

        $order->update($attributes);

        return redirect('/orders')->with('success', 'Order '.$order->customer_name.' ditanda selesai.');
    }
}
