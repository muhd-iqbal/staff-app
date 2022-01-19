<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
            if (substr(strtoupper(request('search')), 0, 1) === env('ORDER_PREFIX')) {
                return redirect('/orders/view/' . (int)substr(request('search'), 1));
            }
        } elseif (request('search')) {
            $orders->where('customer_name', 'like', '%' . request('search') . '%')
                ->orWhere('customer_phone', 'like', '%' . request('search') . '%');
        }

        if (!$orders->count()) {

            $orders = Order::whereHas('order_item', function ($query) {
                $query->where('product', 'like', '%' . request('search') . '%');
            });
        }

        return view('orders.index', [
            'orders' => $orders->paginate(20),
        ]);
    }

    public function index_nopickup()
    {
        //for order which not picked up yet
        return view('orders.no_pickup', [
             'orders' => Order::where('isDone', '=', '1')->whereNull('pickup')->paginate(20)
        ]);
    }

    public function index_location($location)
    {
        $orders = Order::where('location', '=', $location)->with('order_item')->orderBy('isDone', 'ASC')->orderBy('created_at', 'DESC');

        return view('orders.index', [
            'orders' => $orders->paginate(20),
        ]);
    }

    public function create()
    {
        return view('orders.create', [
            'products' => $this->products,
            'customers' => Customer::get(),
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
        $attributes['user_id'] = auth()->user()->id;
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

    public function update_undone(Order $order)
    {
        $attributes['isDone'] = 0;

        $order->update($attributes);

        return redirect('/orders')->with('success', 'Order ' . $order->customer_name . ' ditanda tidak selesai.');
    }

    public function edit(Order $order)
    {
        return view('orders.edit', [
            'order' => $order,
            'customers' => Customer::select(['id', 'name', 'phone'])->get(),
        ]);
    }

    public function update(Order $order)
    {
        $attributes = request()->validate([
            'customer_id' => 'required|numeric',
            'dateline' => 'nullable|date',
            'method' => ['required', Rule::in(['walkin', 'online'])],
            'location' => ['required', Rule::in(['gurun', 'guar'])],
        ]);

        $order->update($attributes);

        return redirect('/orders/view/' . $order->id)->with('success', 'Order berjaya dikemaskini.');
    }

    public function delete(Order $order)
    {
        try {
            $order->delete();
            return redirect('/orders')->with('success', 'Order berjaya padam.');
        } catch (\Exception $e) {
            return redirect('/orders/view/' . $order->id)->with('forbidden', 'Sila padam item terlebih dahulu.');
        }
    }

    public function pickup(Order $order)
    {
        return view('orders.edit_pickup', [
            'order' => $order,
        ]);
    }

    public function update_pickup(Order $order)
    {
        request()->validate([
            'pickup_type' => [Rule::in(['Gurun','Guar','Kurier'])],
        ]);

        $attributes['pickup'] = request('pickup_type');
        $attributes['pickup_time'] = now();

        if(request('pickup') != ""){
            $attributes['pickup'] .= '-' . request('pickup');
        }

        $order->update($attributes);

        return redirect('/orders/view/' . $order->id)->with('success', 'Order dikemaskini.');
    }
}
