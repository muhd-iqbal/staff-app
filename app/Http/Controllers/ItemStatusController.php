<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

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
        $attributes['is_done'] = 1;
        $attributes['is_done_time'] = NOW();

        $item->update($attributes);

        return back()->with('success', 'Status Dikemaskini: Siap');

    }
}
