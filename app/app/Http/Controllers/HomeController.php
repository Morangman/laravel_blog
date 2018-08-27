<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/home');
    }
    
    public function getUserAgentLanguage(Request $request){
        //$info = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        //$info = $_SERVER['HTTP_USER_AGENT'];
        //dd($info);
        
        //$known_langs = array('en', 'ru');
        $user_pref_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        foreach($user_pref_langs as $idx => $lang) {
            $lang = substr($lang, 0, 2);
            if ($lang == 'ru') {
                echo "Предпочтительный язык - ru"."</br></br>";
                break;
            } 
            if($lang == 'en')
            {
                echo "Предпочтительный язык - en"."</br></br>";
                break;
            }
        }
        
        $a = [
            [
                "clientId"=>true,
                 "client"=>true,
            ]
        ];
        
        if($a[0]['clientId'] || $a[0]['client']){
            echo "true"."</br></br>";
        }
        
        echo (\Auth::user()->id);
    }
    

}
