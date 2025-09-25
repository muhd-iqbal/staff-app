<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPicture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ItemStatusController;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    public function create($order)
    {
        return view('orders.create_item', [
            'order' => Order::find($order),
            'measurements' => $this->measurement,
        ]);
    }

    public function insert($order)
    {
        $attributes = request()->validate([
            'product' => 'required|max:255',
            'size' => 'required|max:100',
            'measurement' => ['max:2', Rule::in(array_keys($this->measurement))],
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|min:0|numeric',
            'finishing' => 'max:10000',
            'remarks' => 'max:10000',
        ]);
        if (request()->has('printing_list')) {
            $attributes['printing_list'] = 1;
        }
        if (request()->has('is_urgent')) {
            $attributes['is_urgent'] = 1;
        }
        $attributes['price'] = $attributes['price'] * 100; //for database precision
        $attributes['total'] = $attributes['price'] * $attributes['quantity'];
        $attributes['order_id'] = $order;

        OrderItem::create($attributes);
        DB::table('orders')->where('id', $attributes['order_id'])->increment('total', $attributes['total']);
        order_adjustment($attributes['order_id']);

        return redirect('/orders/view/' . $order)->with('success', 'Item ditambah.');
    }

    public function view(OrderItem $item)
    {
        $status = $this->status_list['none'];

        if ($item->is_done) {
            $status = $this->status_list['is_done'];
        } elseif ($item->is_printing) {
            $status = $this->status_list['is_printing'];
        } elseif ($item->is_approved) {
            $status = $this->status_list['is_approved'];
        } elseif ($item->is_design) {
            $status = $this->status_list['is_design'];
        }

        return view('orders.view_item', [
            'item' => $item,
            'pictures' => OrderPicture::where('order_item_id', $item->id)->get(),
            'users' => User::where('active', 1)->whereNotIn('position_id', [1])->get(),
            'status' => $status,
            'suppliers' => Supplier::get(),
            'measurements' => $this->measurement,
        ]);
    }

    public function update_user(OrderItem $item)
    {
        $attributes = request()->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $attributes['is_design'] = 1;
        $attributes['is_design_time'] = NOW();

        $item->update($attributes);

        return back()->with('success', 'Designer Dilantik.');
    }

    public function update_sub(OrderItem $item)
    {
        $attributes = request()->validate([
            'supplier_id' => 'required|exists:suppliers,id',
        ]);
        $item->update($attributes);

        return back()->with('success', 'Subcon dikemaskini');
    }

    public function update_status(OrderItem $item)
    {
        $status = array_keys($this->status);
        request()->validate([
            'status' =>  ['required', Rule::in($status)],
        ]);

        switch (request('status')) {
            case $status[0]:
                $attribute = array(
                    $status[0] => 1,
                    $status[1] => 0,
                    $status[2] => 0,
                );
                break;
            case $status[1]:
                $attribute = array(
                    $status[0] => 1,
                    $status[1] => 1,
                    $status[2] => 0,
                );
                break;
            case $status[2]:
                $attribute = array(
                    $status[0] => 1,
                    $status[1] => 1,
                    $status[2] => 1,
                );
                break;
            default:
                $attribute = array(
                    $status[0] => 0,
                    $status[1] => 0,
                    $status[2] => 0,
                );
        }

        $item->update($attribute);

        return back()->with('success', 'Status Dikemaskini.');
    }

    public function update_takeover(OrderItem $item)
    {
        $isDesign = 'is_design'; //hard code sorry for asking

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

    public function edit(OrderItem $item)
    {
        return view('orders.edit_item', [
            'item' => $item,
            'measurements' => $this->measurement,
        ]);
    }

    public function update(OrderItem $item)
    {
        $attributes = request()->validate([
            'product' => 'required|max:255',
            'size' => 'required|max:100',
            'quantity' => 'required|numeric|min:1',
            'measurement' => ['max:2', Rule::in(array_keys($this->measurement))],
            'price' => 'required|min:0|numeric',
            'finishing' => 'max:10000',
            'remarks' => 'max:10000',
        ]);

        if (request()->has('printing_list')) {
            $attributes['printing_list'] = 1;
        } else {
            $attributes['printing_list'] = 0;
        }

        if (request()->has('is_urgent')) {
            $attributes['is_urgent'] = 1;
        } else {
            $attributes['is_urgent'] = 0;
        }

        $attributes['price'] = $attributes['price'] * 100; //for database precision
        $attributes['total'] = $attributes['price'] * $attributes['quantity'];
        $item->update($attributes);
        order_adjustment($item->order_id);
        recalculate_order($item->order_id);

        return redirect('/orders/item/' . $item->id)->with('success', 'Item Dikemaskini.');
    }

    public function delete(OrderItem $item)
    {
        try {
            DB::table('order_pictures')->where('order_item_id', '=', $item->id)->delete();

            DB::table('orders')->where('id', $item->order_id)->decrement('total', $item->total);

            $item->delete();

            order_adjustment($item->order_id);
            recalculate_order($item->order_id);

            return redirect('/orders/view/' . $item->order_id)->with('success', 'Item berjaya padam.');
        } catch (\Exception $e) {

            return redirect('/orders/view/' . $item->order_id)->with('forbidden', 'Ralat, sila hubungi system developer.');
        }
    }

    public function delete_photo(OrderPicture $picture)
    {
        $picture->delete();

        return back()->with('success', 'Item berjaya padam.');
    }

    public function updateNote(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->note = $request->input('note');
        $item->save();

        return back()->with('success', 'Note updated successfully!');
    }
}
