<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //проверка на админа
    public function admin()
    {
        if(\Auth::user()->is_admin == 1){
            return view('dashboard');
        } 
        if(\Auth::user()->is_admin == 1){
            return view('post');
        } 
        if(\Auth::user()->is_admin !== 1){
            return view('home');
        } 
    }
}
