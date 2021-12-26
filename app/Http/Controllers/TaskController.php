<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('staff/todo', [
            'todo' => OrderItem::where('user_id', '=', $user->id)->where('is_approved', '=', 0)->with('order')->get(),
        ]);
    }

    public function view_print()
    {
        // return OrderItem::where('is_approved', '=', 1)->where('is_printing', '=', 0)->with('order')->get();
        return view('staff/print', [
            'print' => OrderItem::where('is_approved', '=', 1)->where('is_printing', '=', 0)->where('printing_list', '=', 1)->with('order')->get(),
        ]);
    }
}
