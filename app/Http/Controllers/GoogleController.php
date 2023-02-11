<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    function google_redirect(){
        return Socialite::driver('google')->redirect();
    }
    
    function google_callback(){
        $user = Socialite::driver('google')->user();
        
        if(Customerlogin::where('email', $user->getEmail())->exists()){
            if(Auth::guard('customerlogin')->attempt([
                'email'=>$user->getEmail(),
                'password'=>'Aa@12456',
                ])){
                return redirect('/');
            }
        }
        else{
            Customerlogin::insert([
                'name'=>$user->getName(),
                'email'=>$user->getEmail(),
                'password'=>bcrypt('Aa@12456'),
            ]);
    
            if(Auth::guard('customerlogin')->attempt([
                'email'=>$user->getEmail(),
                'password'=>'Aa@12456',
                ])){
                return redirect('/');
            }
        }
       
    }
}