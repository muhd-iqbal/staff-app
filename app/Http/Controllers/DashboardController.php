<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $links = [
        'Muat Naik Foto' => '/profile/upload',
        'Maklumat Peribadi' => '/profile',
        'Tukar Kata Laluan' => '/change-password',
        'Perihal Cuti' => '/leaves',
        'Tugasan Semasa' => '/view-designer',
        'Perihal Staf' => '/staff',
        'Senarai Order' => '/orders',
        'Tugasan Design' => '/to-do',
        'Print List' => '/print',
        'Pelanggan' => '/customers',
    ];
    protected $links_admin = [
        'Permohonan Cuti' => '/leaves/approval',
        'Jenis Cuti' => '/top/leave-types',
        'Daftar Staf' => '/register',
    ];
    protected $links_owner = [
        // 'Permohonan Cuti' => '/top/leaves/approval',
    ];

    public function index()
    {
        if (auth()->user()->isAdmin) {
            return view('dashboard', [
                'links' => $this->links,
                'links_admin' => $this->links_admin,
            ]);

        } elseif (auth()->user()->position_id == 1) {

            return view('dashboard', [
                'links' => $this->links,
                'links_admin' => $this->links_admin,
                'links_owner' => $this->links_owner,
            ]);
        } else {
            return view('dashboard', [
                'links' => $this->links,
            ]);
        }
    }
}
