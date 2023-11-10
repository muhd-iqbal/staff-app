<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\QuotationPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class QuotationItemController extends Controller
{
    public function insert($quote)
    {
        $attributes = request()->validate([
            'product' => 'required|max:255',
            'size' => 'required|max:100',
            'measurement' => ['max:2', Rule::in(array_keys($this->measurement))],
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|min:0|numeric',
        ]);

        $attributes['price'] = $attributes['price'] * 100; //for database precision
        $attributes['total'] = $attributes['price'] * $attributes['quantity'];
        $attributes['quotation_id'] = $quote;

        QuotationItem::create($attributes);
        DB::table('quotations')->where('id', $attributes['quotation_id'])->increment('total', $attributes['total']);
        quote_adjustment($attributes['quotation_id']);

        return redirect('/quote/' . $quote)->with('success', 'Item ditambah.');
    }

    public function delete(Quotation $quote, QuotationItem $list)
    {
        // DB::table('quotation_items')->where('id', '=', $item->id)->delete();

        DB::table('quotations')->where('id', $quote->id)->decrement('total', $list->total);

        $list->delete();

        quote_adjustment($quote->id);

        return redirect('/quote/' . $quote->id)->with('success', 'Item berjaya padam.');
    }

    public function view(Quotation $quote, QuotationItem $item)
    {
        return view('quote.view_item', [
            'quote' => $quote,
            'item' => $item,
            'pictures' => QuotationPicture::where('quotation_item_id', $item->id)->get(),
            'measurements' => $this->measurement, 
        ]);
    }

    public function update(Quotation $quote, QuotationItem $list)
    {
        $attributes = request()->validate([
            'product' => 'required|max:255',
            'size' => 'required|max:100',
            'measurement' => ['max:2', Rule::in(array_keys($this->measurement))],
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|min:0|numeric',
        ]);

        $attributes['price'] = $attributes['price'] * 100; // for database precision
        $attributes['total'] = $attributes['price'] * $attributes['quantity'];

        $list->update($attributes);

        $totalDifference = $attributes['total'] - $list->total;
        DB::table('quotations')->where('id', $quote->id)->increment('total', $totalDifference);

        quote_adjustment($quote->id);

        return redirect('/quote/' . $quote->id . '/list/' . $list->id)->with('success', 'Item berjaya dikemaskini.');
    }

}
