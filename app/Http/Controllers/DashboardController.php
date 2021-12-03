<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $links = [
        'Muat Naik Foto' => '/profile/upload',
        'Maklumat Peribadi' => '/profile',
        'Perihal Cuti' => '/leaves',
        'Perihal Staf' => '/staff',
        'Senarai Permohonan Cuti' => '/leaves/approval',
        'Senarai Permohonan Cuti (Top)' => '/top/leaves/approval',
        'Jenis Cuti' => '/top/leave-types',
        'Daftar Staf' => '/register',
        'Senarai Order' => '/orders',
    ];

    public function index()
    {
        return view('dashboard', [
            'links' => $this->links,
        ]);
    }
}
