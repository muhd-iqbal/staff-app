<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemStatusController extends Controller
{

    public function update_design(OrderItem $item)
    {
        $attributes['is_design'] = 1;
        $attributes['is_design_time'] = NOW();
        $attributes['is_approved'] = 0;
        $attributes['is_approved_time'] = null;
        $attributes['is_printing'] = 0;
        $attributes['is_printing_time'] = null;
        $attributes['is_done'] = 0;
        $attributes['is_done_time'] = null;

        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Design.');
    }
    public function update_approved(OrderItem $item)
    {
        $attributes['is_approved'] = 1;
        $attributes['is_approved_time'] = NOW();
        $attributes['is_printing'] = 0;
        $attributes['is_printing_time'] = null;
        $attributes['is_done'] = 0;
        $attributes['is_done_time'] = null;

        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Printing');
    }
    public function update_printing(OrderItem $item)
    {
        $attributes['is_printing'] = 1;
        $attributes['is_printing_time'] = NOW();
        $attributes['is_done'] = 0;
        $attributes['is_done_time'] = null;

        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Finishing');
    }
    public function update_done(OrderItem $item)
    {
        $attributes['is_printing'] = 1;
        $attributes['is_printing_time'] = NOW();
        $attributes['is_done'] = 1;
        $attributes['is_done_time'] = NOW();

        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Siap');
    }

    public function show_status($status)
    {
        switch ($status) {
            case 'is_done':
                $title = 'Done';
                $items = OrderItem::where('is_done', '=', 1);
                break;
            case 'is_printing':
                $title = 'Printing';
                $items = OrderItem::where('is_printing', '=', 1)->where('is_done', '=', 0);
                break;
            case 'is_approved':
                $title = 'Production';
                $items = OrderItem::where('is_approved', '=', 1)->where('is_printing', '=', 0);
                break;
            case 'is_design':
                $title = 'Design';
                $items = OrderItem::where('is_design', '=', 1)->where('is_approved', '=', 0);
                break;
            case 'is_pending':
                $title = 'Pending';
                $items = OrderItem::where('is_design', '=', 0);
                break;
            default:
                abort(404);
                break;
        }

        return view('orders/item_status', [
            'status' => $title,
            'items' => $items->paginate(10),
        ]);
    }
}
