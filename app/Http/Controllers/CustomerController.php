<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('name');

        if (request('search')) {
            $customers->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('phone', 'like', '%' . request('search') . '%');
        }
        return view('customers.index', [
            'customers' => $customers->paginate(20),
        ]);
    }

    public function select(Customer $customer)
    {
        return view('customers.view', [
            'customer' => $customer,
            'orders' => Order::with(['branch'])->where('customer_id', $customer->id)->orderBy('id', 'DESC')->paginate(20),
        ]);
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', [
            'customer' => $customer,
            'states' => $this->states,
        ]);
    }

    public function create()
    {
        return view('customers.create', [
            'states' => $this->states,
        ]);
    }

    public function update(Customer $customer)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'organisation' => 'nullable',
            'phone' => 'required|numeric|digits_between:9,12',
            'email' => 'email|nullable|max:100',
            'address' => 'nullable|required_with:city,postcode,state|max:255',
            'city' => 'nullable|required_with:address,city,state|max:50',
            'postcode' => 'nullable|required_with:address,city,state|min:5|max:5',
            'state' => 'nullable|required_with:address,city,postcode|min:3|max:3',
        ]);

        $customer->update($attributes);

        return back()->with('success', 'Maklumat pelanggan berjaya dikemaskini.');
    }

    public function insert()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'organisation' => 'nullable',
            'phone' => 'required|numeric|digits_between:9,12',
            'email' => 'email|nullable|max:100',
            'address' => 'nullable|required_with:city,postcode,state|max:255',
            'city' => 'nullable|required_with:address,city,state|max:50',
            'postcode' => 'nullable|required_with:address,city,state|min:5|max:5',
            'state' => 'nullable|required_with:address,city,postcode|min:3|max:3',
        ]);

        Customer::create($attributes);

        return redirect('/customers')->with('success', 'Pelanggan ditambah.');
    }

    public function agent(Customer $customer)
    {
        $attr = request()->validate([
            'password' => 'max:100|required_with:is_agent'
        ]);

        $attr['password'] = Hash::make($attr['password']);

        if (request()->has('is_agent')) {
            $attr['is_agent'] = 1;
        }
        else{
            $attr['is_agent'] = 0;
            $attr['password'] = null;
        }

        $customer->update($attr);

        return back()->with('success', 'Status ejen dikemaskini');
    }
}
