<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $links_acc = [
        'Muat Naik Foto' => '/profile/upload',
        'Maklumat Peribadi' => '/profile',
        'Tukar Kata Laluan' => '/change-password',
    ];
    protected $links_staff = [
        'Permohonan Cuti' => '/leaves',
        // 'Tugasan Semasa' => '/view-designer',
        'Perihal Staf' => '/staff',
    ];
    protected $links_order = [
        'Senarai Order' => '/orders',
        'Tugasan Design' => '/to-do',
        'Print List' => '/print',
        'Senarai Pelanggan' => '/customers',
    ];
    protected $links_admin = [
        'Daftar Staf' => '/register',
        'Senarai Cuti Staf' => '/leaves/list',
        'Permohonan Cuti Staf' => '/leaves/approval',
    ];
    protected $links_owner = [
        // 'Permohonan Cuti' => '/top/leaves/approval',
    ];

    public function index()
    {
        if (auth()->user()->isAdmin) {
            return view('dashboard', [
                'links_acc' => $this->links_acc,
                'links_staff' => $this->links_staff,
                'links_order' => $this->links_order,
                'links_admin' => $this->links_admin,
            ]);

        } elseif (auth()->user()->position_id == 1) {

            return view('dashboard', [
                'links_acc' => $this->links_acc,
                'links_staff' => $this->links_staff,
                'links_order' => $this->links_order,
                'links_admin' => $this->links_admin,
                'links_owner' => $this->links_owner,
            ]);
        } else {
            return view('dashboard', [
                'links_acc' => $this->links_acc,
                'links_staff' => $this->links_staff,
                'links_order' => $this->links_order,
            ]);
        }
    }

    public function index_admin()
    {
        return view('dashboard', [
            'links_admin' => $this->links_admin
        ]);
    }
}
