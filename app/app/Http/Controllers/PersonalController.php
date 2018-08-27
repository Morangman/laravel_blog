<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PersonalController extends Controller
{
    public function index() {
        return view('personal');
    }
}
