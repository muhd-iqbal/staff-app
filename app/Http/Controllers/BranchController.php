<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        return view('branches.index', [
            'branches' => Branch::get(),
        ]);
    }

    public function view(Branch $branch)
    {
        return view('branches.view', [
            'branch' => $branch,
        ]);
    }

    public function update(Branch $branch)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'shortname' => 'required|max:10',
            'address' => 'required|max:255',
            'phone_1' => 'required|numeric',
            'phone_2' => 'numeric',
            'whatsapp_1' => 'required|numeric',
            'whatsapp_2' => 'numeric',
            'bank_account_1' => 'required|max:255',
            'bank_account_2' => 'nullable|max:255',
            'bank_account_3' => 'nullable|max:255',
            'foot_note' => 'nullable',
            'color_code' => 'required',
        ]);

        $branch->update($attributes);

        return back()->with('success', 'Maklumat syarikat berjaya dikemaskini.');
    }
}
