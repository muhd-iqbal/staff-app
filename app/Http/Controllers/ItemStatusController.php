<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemStatusController extends Controller
{

    public function update_design(OrderItem $item)
    {
        $attributes = array(
            'is_design' => 1,
            'is_design_time' => NOW(),
            'is_approved' => 0,
            'is_approved_time' => null,
            'is_printing' => 0,
            'is_printing_time' => null,
            'is_done' => 0,
            'is_done_time' => null,
            'supplier_id' => null,
        );
        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Design.');
    }
    public function update_approved(OrderItem $item)
    {
        $attributes = array(
            'is_approved' => 1,
            'is_approved_time' => NOW(),
            'is_printing' => 0,
            'is_printing_time' => null,
            'is_done' => 0,
            'is_done_time' => null,
            'printing_list' => 0,
            'location' => 'gurun',
        );
        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Production');
    }

    public function update_approved_guar(OrderItem $item)
    {
        $attributes = array(
            'is_approved' => 1,
            'is_approved_time' => NOW(),
            'is_printing' => 0,
            'is_printing_time' => null,
            'is_done' => 0,
            'is_done_time' => null,
            'printing_list' => 0,
            'location' => 'guar',
        );
        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Production');
    }

    public function update_approved_prod(OrderItem $item)
    {
        $attributes = array(
            'is_approved' => 1,
            'is_approved_time' => NOW(),
            'is_printing' => 0,
            'is_printing_time' => null,
            'is_done' => 0,
            'is_done_time' => null,
            'printing_list' => 1,
            'location' => 'gurun',
        );
        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Production & masuk print list');
    }

    public function update_approved_sub(OrderItem $item)
    {
        $attributes = array(
            'printing_list' => 0,
            'is_approved' => 1,
            'is_approved_time' => NOW(),
            'is_printing' => 0,
            'is_printing_time' => null,
            'is_done' => 0,
            'is_done_time' => null,
            'supplier_id' => 1,
        );
        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Subcon. Sila ubah sub di halaman item');
    }

    public function update_printing(OrderItem $item)
    {
        $attributes = array(
            'is_printing' => 1,
            'is_printing_time' => NOW(),
            'is_done' => 0,
            'is_done_time' => null,
        );
        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Finishing');
    }
    public function update_done(OrderItem $item)
    {
        $attributes = array(
            'is_printing' => 1,
            'is_printing_time' => NOW(),
            'is_done' => 1,
            'is_done_time' => NOW(),
        );
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
                switch (request('loc')) {
                    case 'guar':
                        $items->whereNull('supplier_id')->where('location', '=', 'guar');
                        break;
                    case 'gurun':
                        $items->whereNull('supplier_id')->where('location', '=', 'gurun');
                        break;
                    case 'subcon':
                        $items->whereNotNull('supplier_id');
                        break;
                }
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

        return view('orders.item_status', [
            'status' => $title,
            'items' => $items->paginate(20),
        ]);
    }
}
