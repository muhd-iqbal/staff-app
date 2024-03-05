<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $links_acc = [
        'Muat Naik Foto' => '/profile/upload',
        'Maklumat Peribadi' => '/profile',
        'Slip Gaji' => '/payslips',
        'Permohonan Cuti' => '/leaves',
        'Graf Design Staff' => '/staff-reports',
        'Tukar Kata Laluan' => '/change-password',
        'Baucer Bayaran' => '/payment-vouchers',
        'Aktiviti Syarikat' => 'http://192.168.1.110/event/',
    ];
    protected $links_staff = [
        'Peti Tunai' => '/cashflow',                
              
        'POS Lama' => '/orders/old',
    ];
    protected $links_order = [
        'Senarai Order' => '/orders',
        'Senarai Sebut Harga' => '/quote',
        'Tugasan Design' => '/to-do',        
        'Inventory' => 'https://sys.inspirazs.com/inventory/',
        'Print List' => '/print',
        'Senarai Pelanggan' => '/customers',
        'Senarai Sub / Supplier' => '/suppliers',
        
    ];
    protected $links_admin = [
        'Daftar Staf' => '/register',
        'Graf Jualan' => '/reports',
        
        'Perihal Staf' => '/staff', 
        'Senarai Cuti Staf' => '/leaves/list',
        'Permohonan Cuti Staf' => '/leaves/approval',
        'Cawangan' => '/branches',
        'Slip Gaji Staf' => '/admin/payslips',
    ];
    protected $links_owner = [
        // 'Permohonan Cuti' => '/top/leaves/approval',
    ];

    protected $birthday = 0;

    public function index()
    {
        if (date('Y-m-d') >= auth()->user()->birthday_reminder && auth()->user()->birthday_reminder != null) {
            $this->birthday = 1;
        }
        if (auth()->user()->isAdmin) {
            return view('dashboard', [
                'links_acc' => $this->links_acc,
                'links_staff' => $this->links_staff,
                'links_order' => $this->links_order,
                'links_admin' => $this->links_admin,
                'bday' => $this->birthday,
            ]);
        } elseif (auth()->user()->position_id == 1) {

            return view('dashboard', [
                'links_acc' => $this->links_acc,
                'links_staff' => $this->links_staff,
                'links_order' => $this->links_order,
                'links_admin' => $this->links_admin,
                'links_owner' => $this->links_owner,
                'bday' => $this->birthday,
            ]);
        } else {
            return view('dashboard', [
                'links_acc' => $this->links_acc,
                'links_staff' => $this->links_staff,
                'links_order' => $this->links_order,
                'bday' => $this->birthday,
            ]);
        }
    }

    public function index_admin()
    {
        return view('dashboard', [
            'links_admin' => $this->links_admin
        ]);
    }

    public function easter()
    {
        $user = User::find(auth()->id());
        $attr['birthday_reminder'] = get_next_birthday($user->birthday);
        $user->update($attr);
        return back();
    }
}
