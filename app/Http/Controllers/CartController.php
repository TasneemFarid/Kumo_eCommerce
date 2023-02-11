<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\Whishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_store(Request $request){
        // $request->validate([
        //     'color_id'=>'required',
        //     'size_id'=>'required',
        // ]);
       
        if($request->btns == 1){
            if(Auth::guard('customerlogin')->check()){
                if($request->color_id == ''){
                    $color_id = 1;
                }
                else{
                    $color_id = $request->color_id;
                }
                if($request->size_id == ''){
                    $size_id = 1;
                }
                else{
                    $size_id = $request->size_id;
                }
                
                if(Inventory::where('product_id', $request->product_id)->where('color_id', $color_id)->where('size_id', $size_id)->first()->quantity <= 0){
                    $stock = 0;
                }
                else{
                    $stock = Inventory::where('product_id', $request->product_id)->where('color_id', $color_id)->where('size_id', $size_id)->first()->quantity;
                }
                
                if($request->quantity > Inventory::where('product_id', $request->product_id)->where('color_id', $color_id)->where('size_id', $size_id)->first()->quantity){
                    return back()->with('total_stock','Total Stock: '.$stock);
                }
                else{
                    Cart::insert([
                        'customer_id'=>Auth::guard('customerlogin')->id(),
                        'product_id'=>$request->product_id,
                        'color_id'=>$color_id,
                        'size_id'=>$size_id,
                        'quantity'=>$request->quantity,
                        'created_at'=>Carbon::now(),
                     ]);
                     return back()->with('cart_add','Added to Cart!!');
                }
            }
            else{
                return redirect()->route('customer_login_register')->with('login','Please login to add cart!!');
            }
            
        }
        else{
            if(Auth::guard('customerlogin')->check()){
                if($request->color_id == ''){
                    $color_id = 1;
                }
                else{
                    $color_id = $request->color_id;
                }
                if($request->size_id == ''){
                    $size_id = 1;
                }
                else{
                    $size_id = $request->size_id;
                }
                Whishlist::insert([
                    'customer_id'=>Auth::guard('customerlogin')->id(),
                    'product_id'=>$request->product_id,
                    'color_id'=>$color_id,
                    'size_id'=>$size_id,
                    'quantity'=>$request->quantity,
                 ]);
                 return back()->with('wish','Added to Wishlist!!');
            }
            else{
                return redirect()->route('customer_login_register')->with('login','Please login to add wishlist!!');
            }
        }
        
    }

    function cart_remove($cart_id){
        Cart::find($cart_id)->delete();
        return back();
    }

    function cart_clear(){
        Cart::where('customer_id', Auth::guard('customerlogin')->id())->delete();
        return back();
    }
    function wish_remove($wishlist_id){
        Whishlist::find($wishlist_id)->delete();
        return back();
    }

    function wish_clear(){
        Whishlist::where('customer_id', Auth::guard('customerlogin')->id())->delete();
        return back();
    }

    function cart(Request $request){
        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        $coupon_code = $request->coupon;
        
        $discount = 0;
        $message = '';
        $type = '';

        if ($coupon_code == ''){
            $discount = 0;
        }
        else{
            if (Coupon::where('coupon_code', $coupon_code)->exists()) {
                if(Carbon::now()->format('Y-m-d') > Coupon::where('coupon_code', $coupon_code)->first()->validity){
                    $discount = 0;
                    $message = 'Coupon Code Expired!!';
                }
                else{
                    $discount = Coupon::where('coupon_code', $coupon_code)->first()->amount;
                    $type = Coupon::where('coupon_code', $coupon_code)->first()->type;
                }
            }
            else{
                $discount = 0;
                $message = "Invalid Coupon Code!!";
            }
        }
        return view('frontend.cart', [
            'carts'=>$carts,
            'discount'=>$discount,
            'message'=>$message,
            'type'=>$type,
        ]);
    }

    function cart_update(Request $request){
        foreach($request->quantity as $cart_id=>$quantity){
            Cart::find($cart_id)->update([
                'quantity'=>$quantity,
            ]);
        }
        return back();
    }

    function wishlist(){
        $wishlists = Whishlist::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.wishlist', [
            'wishlists'=>$wishlists,
        ]);
    }
}