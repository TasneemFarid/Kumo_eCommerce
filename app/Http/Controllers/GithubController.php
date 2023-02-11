<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GithubController extends Controller
{
    function github_redirect(){
        return Socialite::driver('github')->redirect();
    }
    
    function github_callback(){
        $user = Socialite::driver('github')->user();
        
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