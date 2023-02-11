<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    function customer_login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if(Auth::guard('customerlogin')->attempt(['email'=>$request->email, 'password'=>$request->password])){
            if(Auth::guard('customerlogin')->user()->email_verified_at == NULL){
                return redirect()->route('customer_login_register')->with('verify_error', 'Please verify your email.');
            }
            else{
                return redirect('/');
            }
        }
        else{
            return redirect()->route('customer_login_register');
        }
    }

    function customer_logout(){
        Auth::guard('customerlogin')->logout();
        return redirect('/');
    }
}