<?php

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

$status_list = [
    'none' => 'Pending',
    'is_design' => 'Design',
    'is_approved' => 'Production',
    'is_printing' => 'Finishing',
    'is_done' => 'Done'
];

// reformat payment number with prefix zeroes
if (!function_exists('payment_num')) {

    function payment_num($var)
    {
        return str_pad($var, 6, '0', STR_PAD_LEFT);
    }
}

//reformat phone number displays
if (!function_exists('phone_format')) {
    function phone_format($phoneNumber)
    {
        if (strlen($phoneNumber) == 10) { //XXX-XXX XXXX
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = $areaCode . '-' . $nextThree . ' ' . $lastFour;
        } else if (strlen($phoneNumber) == 9) { // XX-XXX XXXX
            $areaCode = substr($phoneNumber, 0, 2);
            $nextThree = substr($phoneNumber, 2, 3);
            $lastFour = substr($phoneNumber, 5, 4);

            $phoneNumber = $areaCode . '-' . $nextThree . ' ' . $lastFour;
        } else if (strlen($phoneNumber) == 11) { // XXX-XXXX XXXX
            $areaCode = substr($phoneNumber, 0, 3);
            $nextFour = substr($phoneNumber, 3, 4);
            $lastFour = substr($phoneNumber, 7, 4);

            $phoneNumber = $areaCode . '-' . $nextFour . ' ' . $lastFour;
        }
        return $phoneNumber;
    }
}

// assign order number based on prefix on env file
if (!function_exists('order_num')) {
    function order_num($var)
    {
        return env('ORDER_PREFIX') . str_pad($var, 5, '0', STR_PAD_LEFT);
    }
}

//helper to make grandtotal and due updated on row update

if (!function_exists('order_adjustment')) {
    function order_adjustment($id)
    {
        DB::table('orders')->where('id', $id)->update([
            'grand_total' => DB::raw('`total`-`discount`+`shipping`'),
            'due' => DB::raw('`grand_total`-`paid`')
        ]);
    }
}

// convert integer to money format from database
if(!function_exists('RM')){
    function RM($amount)
    {
        return number_format($amount/100, 2);
    }
}

//calculate order when item change total price
if (!function_exists('recalculate_order')) {
    function recalculate_order($order)
    {
        $statement = "UPDATE orders od
        INNER JOIN (
          SELECT SUM(total) as totals
          FROM order_items
          WHERE order_id = $order
        ) oi ON od.id = $order
        SET od.total = oi.totals";
        DB::statement($statement);
        DB::statement("UPDATE orders SET grand_total = total + shipping - discount, due = grand_total - paid WHERE id = $order");
    }
}
