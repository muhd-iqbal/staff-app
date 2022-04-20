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

    public function index()
    {
        return view('suppliers.index', [
            'suppliers' => Supplier::paginate(20),
        ]);
    }

    public function view(Supplier $supplier)
    {
        return view('suppliers.view', [
            'supplier' => $supplier,
        ]);
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

    public function update(Supplier $supplier)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);

        $supplier->update($attributes);

        return redirect('/suppliers')->with('success', 'Supplier/Subcon dikemaskini');

    }
}
