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
        'red' => 'Banner',
        'purple' => 'Streamer',
        'yellow' => 'Sticker',
        'green' => 'Business Card',
        'pink' => 'Flyers',
        'indigo' => 'Kad Kahwin',
        'gray' => 'Menu Book',
        'blue' => 'Lain-lain'
    ];

    public function index()
    {
        $orders = Order::with('order_item')->orderBy('isDone', 'ASC')->orderBy('created_at', 'DESC');

        if (preg_match('/^[A-Za-z]\d+$/', request('search'))) {
            //    echo $string = preg_replace('/[^a-z]/i', '', request('search'));
            if (substr(strtoupper(request('search')), 0, 1) === env('ORDER_PREFIX')) {
                return redirect('/orders/view/' . (int)substr(request('search'), 1));
            }
        } elseif (request('search')) {
            $orders->where('customer_name', 'like', '%' . request('search') . '%')->orWhere('customer_phone', 'like', '%' . request('search') . '%');
        }

        return view('orders.index', [
            'orders' => $orders->paginate(20),
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

        return redirect('/orders/view/' . $insert->id)->with('success', 'Order berjaya dibuat.');
    }

    public function view(Order $order)
    {
        $lists = OrderItem::with('user')->where('order_id', $order->id)->get();
        if ($lists) :
            return view('orders.view', [
                'order' => $order,
                'lists' => $lists,
            ]);
        else :
            return back()->with('error', 'Order tidak dijumpai, sila masukkan semula.');
        endif;
    }

    public function update_done(Order $order)
    {
        $attributes['isDone'] = 1;

        $order->update($attributes);

        return redirect('/orders')->with('success', 'Order ' . $order->customer_name . ' ditanda selesai.');
    }
}
