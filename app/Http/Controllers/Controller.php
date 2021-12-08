<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function order_num($var)
    {
        return env('ORDER_PREFIX') . str_pad($var, 5, '0', STR_PAD_LEFT);
    }

    public static function phone_format($phoneNumber)
    {
        if(strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = $areaCode.'-'.$nextThree.' '.$lastFour;
        }
        else if(strlen($phoneNumber) == 11) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextFour = substr($phoneNumber, 3, 4);
            $lastFour = substr($phoneNumber, 7, 4);

            $phoneNumber = $areaCode.'-'.$nextFour.' '.$lastFour;
        }
        return $phoneNumber;
    }
}
