<?php

namespace App\Http\Controllers;

use App\Models\Payslip;
use App\Models\User;
use Illuminate\Http\Request;

class PayslipController extends Controller
{

    public function index()
    {
        return view('payslips.index', [
            'payslips' => Payslip::where('user_id', auth()->id())->orderBy('year', 'DESC')->orderBy('month', 'DESC')->get(),
        ]);
    }

    public function indexadmin()
    {
        if(!request('y')||!request('m')){
            return redirect('/admin/payslips?y='.date('Y', strtotime('-1 months')).'&m='.date('n', strtotime('-1 months')));
        }
        else{
            return view('payslips.index_admin', [
                'users' => User::where('active',1)->get(),
                'currents' => Payslip::with('user')->where('month', request('m'))->where('year', request('y'))->get(),
            ]);
        }
    }

    public function create()
    {
        $attr = request()->validate([
            'user_id' => 'required|integer|exists:users,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:'.date("Y"),
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $check = Payslip::with('user')->where('month', request('m'))->where('year', request('y'));

        if($check === null){

            $attr['file'] = request()->file('file')->store('payslip');

            Payslip::create($attr);

            return back()->with('success', 'Slip gaji berjaya dimuat naik.');
        } else {
            return back()->with('forbidden', 'Sila padam rekod lama sebelum muat naik slip baru');
        }
    }

    public function delete(Payslip $payslip)
    {
        $payslip->delete();

        return back()->with('success', 'Slip gaji dipadam.');
    }
}
