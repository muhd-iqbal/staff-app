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
            'todo' => OrderItem::where('user_id', '=', $user->id)->where('isPrinting', '=', 0)->with('order')->get(),
        ]);
    }
}
