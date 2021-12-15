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
        'Perihal Staf' => '/staff',
        'Senarai Order' => '/orders',
        'Tugasan' => '/to-do',
    ];
    protected $links_admin = [
        // 'Permohonan Cuti' => '/leaves/approval',
        // 'Jenis Cuti' => '/top/leave-types',
        'Daftar Staf' => '/register',
    ];
    protected $links_owner = [
        // 'Permohonan Cuti (Top)' => '/top/leaves/approval',
     ];

    public function index()
    {
        if(auth()->user()->isAdmin){
            $links = array_merge($this->links, $this->links_admin);
        }
        elseif(auth()->user()->position_id==1){
            $links = array_merge($this->links, $this->links_admin, $this->links_owner);
        }
        else{
            $links = $this->links;
        }

        return view('dashboard', [
            'links' => $links,
        ]);
    }
}
