<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;

class RateController extends Controller
{
    public function rate(){
        $json = file_get_contents('http://bank-ua.com/export/exchange_rate_cash.json');
        $values = json_decode($json, true);
        //$privat =  $value["6"]; 
        //$date = $privat['date'];
        //$bankName = $privat['bankName'];
        //$usd = $privat['codeAlpha'];
        //$rateBuy = $privat['rateBuy'];
        //$rateSale = $privat['rateSale'];
        return view('/rate', compact('values'));
    }

}
