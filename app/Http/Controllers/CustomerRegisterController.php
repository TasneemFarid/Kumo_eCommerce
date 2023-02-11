<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRegisterRequest;
use App\Models\CustomerEmailVerify;
use App\Models\Customerlogin;
use App\Notifications\CustomerEmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Stripe\Customer;

class CustomerRegisterController extends Controller
{
    function customer_store(CustomerRegisterRequest $request){
        Customerlogin::insert([
           'name'=>$request->name, 
           'email'=>$request->email, 
           'password'=>bcrypt($request->password), 
        ]);

        $customer = Customerlogin::where('email', $request->email)->firstOrFail();
        $customer_info = CustomerEmailVerify::create([
            'customer_id'=>$customer->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);

        Notification::send($customer, new CustomerEmailVerifyNotification($customer_info));
        
        return back()->with('email_verify','A Link has sent to your email, please check and verify.');
        
        // if(Auth::guard('customerlogin')->attempt([
        //     'email'=>$request->email,
        //     'password'=>$request->password,
        //     ])){
        //     return redirect('/')->with('success_login', 'Customer Registration Successfull!!');
        // }
    }

    function customer_email_verify($token){
        $customer = CustomerEmailVerify::where('token', $token)->firstOrFail();
        Customerlogin::find($customer->customer_id)->update([
            'email_verified_at'=>Carbon::now()->format('Y-m-d'),
        ]);

        $customer->delete();

        return back()->with('success_login', 'You are logged in!!');
    }
}