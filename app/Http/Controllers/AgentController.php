<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function login()
    {
        if (session('agent_id')) {
            return redirect('/agent');
        } else {

            $agent =  Customer::where('is_agent', 1)->get();

            return view('agents.login', [
                'agents' => $agent
            ]);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'id' => 'required|exists:customers,id',
            'password' => 'required|max:100|min:6'
        ]);

        $agent = Customer::where('id', $credentials['id'])->first();

        if (Hash::check($credentials['password'], $agent->password)) {
            session(['agent_id' => $agent->id]);
            return redirect('/agent');
        } else {

            return redirect('/agent/login')->with('forbidden', 'Password Salah');
        }
    }

    public function index()
    {
        $agent = Customer::where('id', session('agent_id'))->first();
        $orders = Order::with('branch')->where('customer_id', session('agent_id'))->where('date', '>=', env('POS_START'))->orderBy('created_at', 'DESC')->paginate(5);
        $total = Order::where('customer_id', session('agent_id'))->where('date', '>=', env('POS_START'))->get();
        return view('agents.dashboard', [
            'agent' => $agent,
            'orders' => $orders,
            'total' => $total,
        ]);
    }

    public function logout()
    {
        session()->forget('agent_id');
        return redirect('/agent/login');
    }
}
