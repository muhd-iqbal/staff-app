<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPicture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderItemController extends Controller
{

    protected $status = ['isDesign' => 'Design', 'isPrinting' => 'Print', 'isDone' => 'Selesai'];

    public function create($order)
    {

        return view('orders.create_item', [
            'order' => Order::find($order),
        ]);
    }

    public function insert($order)
    {
        $attributes = request()->validate([
            'product' => 'required|max:255',
            'size' => 'required|max:100',
            'quantity' => 'required|numeric|min:1',
            'remarks' => 'required',
        ]);
        $attributes['order_id'] = $order;

        OrderItem::create($attributes);

        return redirect('/orders/view/' . $order)->with('success', 'Item ditambah.');
    }

    public function view(OrderItem $item)
    {
        return view('orders.view_item', [
            'item' => $item,
            'pictures' => OrderPicture::where('order_item_id', $item->id)->get(),
            'users' => User::where('active',1)->get(),
            'status' => $this->status,
        ]);
    }

    public function update_user(OrderItem $item)
    {
        $attributes = request()->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $item->update($attributes);

        return back()->with('success', 'Designer Dilantik.');
    }

    public function update_status(OrderItem $item)
    {
        $status = array_keys($this->status);
        request()->validate([
            'status' =>  ['required', Rule::in($status)],
        ]);

        switch (request('status')) {
            case $status[0]:
                $attribute[$status[0]] = 1;
                $attribute[$status[1]] = 0;
                $attribute[$status[2]] = 0;
                break;
            case $status[1]:
                $attribute[$status[0]] = 1;
                $attribute[$status[1]] = 1;
                $attribute[$status[2]] = 0;
                break;
            case $status[2]:
                $attribute[$status[0]] = 1;
                $attribute[$status[1]] = 1;
                $attribute[$status[2]] = 1;
                break;
            default:
                $attribute[$status[0]] = 0;
                $attribute[$status[1]] = 0;
                $attribute[$status[2]] = 0;
        }

        $item->update($attribute);

        return back()->with('success', 'Status Dikemaskini.');
    }

    public function update_takeover(OrderItem $item)
    {
        $isDesign = key($this->status);

        $attributes['user_id'] = auth()->user()->id;
        $attributes[$isDesign] = 1;

        $item->update($attributes);

        return back()->with('success', 'Item Diambil Alih.');

    }

    public function update_photo($item)
    {
        request()->validate([
            'picture' => 'required|image'
        ]);

        $attributes['order_item_id'] = $item;
        $attributes['picture'] = request()->file('picture')->store('picture');

        OrderPicture::create($attributes);

        return back()->with('success', 'Gambar ditambah!');
    }
}
