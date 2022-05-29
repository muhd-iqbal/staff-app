<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['order_item', 'customer'])->orderBy('isDone', 'ASC')->orderBy('created_at', 'DESC');

        if (preg_match('/^[A-Za-z]\d+$/', request('search'))) {
            if (substr(strtoupper(request('search')), 0, 1) === env('ORDER_PREFIX')) {
                return redirect('/orders/view/' . (int)substr(request('search'), 1));
            }
        } else if (request('search')) {
            $orders = Order::whereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('phone', 'like', '%' . request('search') . '%')
                    ->orWhere('organisation', 'like', '%' . request('search') . '%');
            })->orderBy('created_at', 'DESC');
        }

        if (!$orders->count()) {

            $orders = Order::whereHas('order_item', function ($query) {
                $query->where('product', 'like', '%' . request('search') . '%');
            })->orderBy('created_at', 'DESC');
        }

        if (request('payment')) {
            switch (request('payment')) {
                case 'unpaid':
                    $orders->where('date', '>=', env('POS_START'))->whereColumn('due', '=', 'grand_total');
                    break;
                case 'partial':
                    $orders->where('date', '>=', env('POS_START'))->where('paid', '>', 0)->whereColumn('paid', '<', 'grand_total');
                    break;
                default:
                    $orders->where('date', '>=', env('POS_START'))->whereColumn('paid', '=', 'grand_total')->where('paid', '>', 0);
                    break;
            }
        }

        return view('orders.index', [
            'orders' => $orders->with('branch')->paginate(20),
            'branches' => Branch::get(),
            'dues' => Order::where('date', '>=', env('POS_START'))->sum('due'),
            'to_be_updated' => OrderItem::where('price', 0)->where('created_at', '>=', date('Y-m-d', strtotime(env('POS_START'))) . ' 00:00:00')->count(),
        ]);
    }

    public function index_nopickup()
    {
        //for order which not picked up yet
        $orders = Order::where('isDone', '=', '1')->whereNull('pickup');

        if (request('branch')) {
            $orders->where('branch_id', request('branch'));
        }
        return view('orders.no_pickup', [
            'orders' => $orders->with(['branch', 'customer'])->orderBy('id', 'DESC')->paginate(20),
            'branches' => Branch::get(),
        ]);
    }

    public function index_location($branch)
    {
        $orders = Order::where('branch_id', '=', $branch)->with('order_item')->orderBy('isDone', 'ASC')->orderBy('created_at', 'DESC');

        return view('orders.index', [
            'orders' => $orders->paginate(20),
            'branches' => Branch::get(),
            'dues' => Order::where('date', '>=', env('POS_START'))->where('branch_id', $branch)->sum('due'),
        ]);
    }

    public function create()
    {
        return view('orders.create', [
            'products' => $this->products,
            'branches' => Branch::get(),
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function insert()
    {
        $attributes = request()->validate([
            'customer_id' => 'required|numeric|exists:customers,id',
            'date' => 'required|date',
            'dateline' => 'nullable|date',
            'method' => ['required', Rule::in(['walkin', 'online'])],
            'branch_id' => 'required|exists:branches,id',
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
            return back()->with('forbidden', 'Order tidak dijumpai, sila masukkan semula.');
        endif;
    }

    public function update_done(Order $order)
    {
        $attributes['isDone'] = 1;

        $order->update($attributes);

        return redirect('/orders')->with('success', 'Order ditanda selesai.');
    }

    public function update_undone(Order $order)
    {
        $attributes['isDone'] = 0;

        $order->update($attributes);

        return redirect('/orders')->with('success', 'Order ditanda tidak selesai.');
    }

    public function edit(Order $order)
    {
        return view('orders.edit', [
            'order' => $order,
            'customers' => Customer::select(['id', 'name', 'phone'])->get(),
            'branches' => Branch::get(),
        ]);
    }

    public function update(Order $order)
    {
        $attributes = request()->validate([
            'customer_id' => 'required|numeric',
            'dateline' => 'nullable|date',
            'method' => ['required', Rule::in(['walkin', 'online'])],
            'branch_id' => 'required|exists:branches,id',
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
            'pickup_type' => [Rule::in(['Gurun', 'Guar', 'Kurier'])],
        ]);

        $attributes['pickup'] = request('pickup_type');
        $attributes['pickup_time'] = now();

        if (request('pickup') != "") {
            $attributes['pickup'] .= '-' . request('pickup');
        }

        $order->update($attributes);

        return redirect('/orders/view/' . $order->id)->with('success', 'Order dikemaskini.');
    }

    public function print(Order $order)
    {
        // return $order;
        return view('orders.print', [
            'order' => $order,
            'payment_method' => $this->payment_method,
            'measurements' => $this->measurement,
        ]);
    }

    public function update_additional(Order $order)
    {
        $attributes = request()->validate([
            'shipping' => 'required|numeric',
            'discount' => 'required|numeric',
        ]);
        $attributes['shipping'] = $attributes['shipping'] * 100;
        $attributes['discount'] = $attributes['discount'] * 100;

        $order->update($attributes);
        order_adjustment($order->id);

        return back()->with('success', 'Info tambahan dikemaskini.');
    }

    public function refresh($order)
    {
        recalculate_order($order);

        return back()->with('success', 'Order dikemaskini.');
    }
}
