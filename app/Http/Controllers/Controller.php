<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //status list for orders - DO NOT CHANGE ANY VALUES
    protected $status_list = [
        'none' => 'Pending',
        'is_design' => 'Design',
        'is_approved' => 'Production',
        'is_printing' => 'Finishing',
        'is_done' => 'Done'
    ];

    //set payment method - DO NOT CHANGE EXISTING VALUES, ADD IS OKAY, KEY MUST NOT EXCEED 10 CHARACTERS
    protected $payment_method = [
        'tunai' => 'Tunai',
        'transfer' => 'Online Transfer',
        'cek' => 'Cek',
        'toyyibpay' => 'FPX - Toyyibpay',
    ];

    public $states = [
        'KDH' => 'Kedah',
        'JHR' => 'Johor',
        'KTN' => 'Kelantan',
        'MLK' => 'Melaka',
        'NSN' => 'Negeri Sembilan',
        'PHG' => 'Pahang',
        'PRK' => 'Perak',
        'PLS' => 'Perlis',
        'PNG' => 'Pulau Pinang',
        'SBH' => 'Sabah',
        'SWK' => 'Sarawak',
        'SGR' => 'Selangor',
        'TRG' => 'Terengganu',
        'KUL' => 'W.P. Kuala Lumpur',
        'LBN' => 'W.P. Labuan',
        'PJY' => 'W.P. Putrajaya',
    ];
}
