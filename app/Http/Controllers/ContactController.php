<?php

namespace App\Http\Controllers;

use App\Models\Contactinfo;
use App\Models\Getintouch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    function get_in_touch(Request $request){
        $request->validate([
           'name'=>'required', 
           'email'=>'required', 
           'subject'=>'required', 
           'message'=>'required|max:255', 
        ]);

        Getintouch::insert([
            'name'=>$request->name, 
            'email'=>$request->email, 
            'subject'=>$request->subject, 
            'message'=>$request->message, 
            'created_at'=>Carbon::now(), 
        ]);
        return back()->withSend('Message Sent!');
    }

    function get_in_touch_list(){
        $messages = Getintouch::all();
        return view('admin.contact.get_in_touch_list',[
            'messages'=>$messages,
        ]);
    }

    function inbox_delete($id){
       Getintouch::find($id)->delete();
       return back();
    }

    function contact_info(){
        $contacts = Contactinfo::find('1');
        return view('admin.contact.contact_info',[
            'contacts'=>$contacts,
        ]);
    }

    function contact_update(Request $request){
        $request->validate([
            'email'=>'required', 
            'customer_care'=>'required', 
            'career'=>'required', 
            'address'=>'required', 
         ]);
 
         Contactinfo::find($request->id)->update([
             'email'=>$request->email, 
             'customer_care'=>$request->customer_care, 
             'career'=>$request->career, 
             'address'=>$request->address, 
             'created_at'=>Carbon::now(), 
         ]);
         return back();
    }
}