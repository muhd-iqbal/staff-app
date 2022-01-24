<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('staff.todo', [
            'todo' => OrderItem::where('user_id', '=', $user->id)->where('is_approved', '=', 0)->orderBy('is_approved', 'ASC')->orderBy('created_at', 'DESC')->with('order')->paginate(20),
        ]);
    }

    public function view_print()
    {
        // return OrderItem::where('is_approved', '=', 1)->where('is_printing', '=', 0)->with('order')->get();
        return view('staff.print', [
            'print' => OrderItem::where('is_approved', '=', 1)->where('is_printing', '=', 0)->where('printing_list', '=', 1)->with('order')->get(),
        ]);
    }
    public function print_print()
    {
        // return OrderItem::where('is_approved', '=', 1)->where('is_printing', '=', 0)->with('order')->get();
        return view('staff.print_blank', [
            'print' => OrderItem::where('is_approved', '=', 1)->where('is_printing', '=', 0)->where('printing_list', '=', 1)->with('order')->get(),
        ]);
    }

    public function previous()
    {
        $user = auth()->user();
        return view('staff.prev_work', [
            'prev' => OrderItem::where('user_id', '=', $user->id)->orderBy('is_approved', 'ASC')->orderBy('created_at', 'DESC')->with('order')->paginate(20),
        ]);
    }

    public function print_sticker($item)
    {
        return view('print.item_sticker', [
            'item' => OrderItem::with('order')->where('id', '=', $item)->first(),
        ]);
    }

    public function print_allstickers()
    {
        if (request('item_id')) {

            $items = OrderItem::whereIn('id', request('item_id'))->with('order')->get();

            return view('print.all_stickers', [
                'items' => $items,
            ]);
        } else {
            return back()->with('forbidden', 'Tanda
            &#9745; sekurang-kurangnya satu list.');
        }
    }

    public function view_designer()
    {
        return view('orders.designers', [
            'users' => User::with('order_item')->where('position_id', '<>', 1)->get(),
        ]);
    }
}
