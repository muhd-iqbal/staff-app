<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuotationController extends Controller
{
    public function index()
    {

        $quotes = Quotation::with(['quote_item', 'customer'])->orderBy('created_at', 'DESC');

        if (preg_match('/^[A-Za-z]\d+$/', request('search'))) {
            if (substr(strtoupper(request('search')), 0, 1) === env('QUOTE_PREFIX')) {
                return redirect('/quote/' . (int)substr(request('search'), 1));
            }
        } else if (request('search')) {
            $quotes = Quotation::whereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('phone', 'like', '%' . request('search') . '%')
                    ->orWhere('organisation', 'like', '%' . request('search') . '%');
            })->orderBy('created_at', 'DESC');
        }

        return view('quote.index', [
            'quotations' => $quotes->paginate(20),
        ]);
    }

    public function create()
    {
        return view('quote.create', [
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
            'method' => ['required', Rule::in(['walkin', 'online'])],
            'branch_id' => 'required|exists:branches,id',
        ]);
        $attributes['user_id'] = auth()->user()->id;
        // $attributes['product'] = implode(',', request('product'));

        $insert = Quotation::create($attributes);

        return redirect('/quote/' . $insert->id)->with('success', 'Sebut harga berjaya dibuat.');
    }

    public function view(Quotation $quote)
    {
        $lists = QuotationItem::where('quotation_id', $quote->id)->get();
        if ($lists) :
            return view('quote.view', [
                'quote' => $quote,
                'lists' => $lists,
                'measurements' => $this->measurement,
            ]);
        else :
            return back()->with('forbidden', ' tidak dijumpai, sila masukkan semula.');
        endif;
    }

    public function print(Quotation $quote)
    {
        return view('quote.print', [
            'quote' => $quote,
            'measurements' => $this->measurement,            // 'branch' => Branch::get(),
        ]);
    }

    public function update_footer(Quotation $quote)
    {
        $attributes = request()->validate([
            'foot_note' => 'nullable'
        ]);

        $quote->update($attributes);

        return back()->with('success', 'Berjaya dikemakini');
    }

    public function delete(Quotation $quote)
    {
        $quote->delete();

        return redirect('/quote')->with('success', 'Sebut harga dipadam!');

    }

    public function export(Quotation $quote)
    {
        $attr['customer_id'] = $quote->customer_id;
        $attr['branch_id'] = $quote->branch_id;
        $attr['user_id'] = auth()->id();
        $attr['date'] = date("Y-m-d");
        $attr['method'] = $quote->method;
        $attr['total'] = $quote->total;
        $attr['shipping'] = $quote->shipping;
        $attr['discount'] = $quote->discount;
        $attr['grand_total'] = $quote->grand_total;

        $order = Order::create($attr);

        foreach ($quote->quote_item as $item) {
            $attrs['order_id'] = $order->id;
            $attrs['product'] = $item->product;
            $attrs['size'] = $item->size;
            $attrs['measurement'] = $item->measurement;
            $attrs['quantity'] = $item->quantity;
            $attrs['price'] = $item->price;
            $attrs['total'] = $item->total;

            OrderItem::create($attrs);
        }

        order_adjustment($order->id);

        $quote->update(['export_to_order' => 1]);

        return redirect('/orders/view/'.$order->id);
    }
}
