<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function create()
    {
        return view('suppliers.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);

        Supplier::create($attributes);

        return redirect(request('prev_url'))->with('success', 'Supplier/Subcon ditambah');
    }
}
