<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\CustomerPassReset;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Notifications\CustomerPassResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class CustomerController extends Controller
{
    function customer_profile(){
        return view('frontend.profile');
    }

    function profile_update(Request $request){
        if($request->password == ''){
            if ($request->photo == '') {
                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                ]);
                return back()->with('success','Update Success!!');
            }
            else{
                if(Auth::guard('customerlogin')->user()->photo != null){
                    $delete_from = public_path('uploads/customer/'.Auth::guard('customerlogin')->user()->photo);
                    unlink($delete_from);
                }
                $uploaded_img = $request->photo;
                $extension = $uploaded_img->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id().'.'.$extension;
                
                Image::make($uploaded_img)->resize(300,200)->save(public_path('uploads/customer/'.$file_name));
                
                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                ]);
                return back()->with('success','Update Success!!');
            }
        }
        else{
            if($request->old_password == ''){
                return back()->with('pass_err','Current Password is required!!');
            }
            else{
                if(Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)){
                    if ($request->photo == '') {
                        Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                            'name'=>$request->name,
                            'email'=>$request->email,
                            'password'=>bcrypt($request->password),
                            'country'=>$request->country,
                            'address'=>$request->address,
                        ]);
                        return back()->with('success','Update Success!!');
                    }
                    else{
                        if(Auth::guard('customerlogin')->user()->photo != null){
                            $delete_from = public_path('uploads/customer/'.Auth::guard('customerlogin')->user()->photo);
                            unlink($delete_from);
                        }
                        $uploaded_img = $request->photo;
                        $extension = $uploaded_img->getClientOriginalExtension();
                        $file_name = Auth::guard('customerlogin')->id().'.'.$extension;
                        
                        Image::make($uploaded_img)->resize(300,200)->save(public_path('uploads/customer/'.$file_name));
                        
                        Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                            'name'=>$request->name,
                            'email'=>$request->email,
                            'password'=>bcrypt($request->password),
                            'country'=>$request->country,
                            'address'=>$request->address,
                            'photo'=>$file_name,
                        ]);
                        return back()->with('success','Update Success!!');
                    }
                }
                else{
                    return back()->with('pass_err','Wrong Input!!');
                }
            }
        }
    }

    function customer_order(){
        $orders = Order::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.customer_order',[
            'orders'=>$orders,
        ]);
    }

    function review_store(Request $request){
        if($request->image == ''){
            OrderProduct::where('customer_id', $request->customer_id)->where('product_id', $request->product_id)->update([
                'review'=>$request->review,
                'star'=>$request->star, 
            ]);
            return back();
        }
        else{
            $uploaded_file = $request->image;
            $extension = $uploaded_file->getClientOriginalExtension();
            $file_name = Auth::guard('customerlogin')->id().'.'.$extension;
            Image::make($uploaded_file)->resize(300,200)->save(public_path('uploads/review/'.$file_name));

            OrderProduct::where('customer_id', $request->customer_id)->where('product_id', $request->product_id)->update([
                'review'=>$request->review,
                'star'=>$request->star, 
                'image'=>$file_name, 
            ]);
            return back();
        }

    }

    function customer_pass_reset_req(){
        return view('frontend.pass_reset.pass_reset_req');
    }

    function customer_pass_reset_req_send(Request $request){
        $customer_info = Customerlogin::where('email', $request->email)->firstOrfail();
        CustomerPassReset::where('customer_id', $customer_info->id)->delete();

        $customer_inserted_info = CustomerPassReset::create([
            'customer_id'=>$customer_info->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);

        Notification::send($customer_info, new CustomerPassResetNotification($customer_inserted_info));
        
        return back()->with('send','A Link has sent to your email, please check.');
    }

    function customer_pass_reset_form($token){
        return view('frontend.pass_reset.pass_reset_form',[
            'token'=>$token,
        ]);
    }

    function pass_reset(Request $request){
        $customer = CustomerPassReset::where('token', $request->token)->firstOrFail();
        
        Customerlogin::findOrFail($customer->customer_id)->update([
            'password'=>Hash::make($request->password),
        ]);

        $customer->delete();
        
        return redirect()->route('customer_login_register')->withSuccess('Password Reset Successfull');
    }
    
}