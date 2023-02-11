<?php

namespace App\Http\Controllers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Image;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function users(){
        $users = User::where('id', '!=', Auth::id())->get();
        $total_count = User::count();
        return view('admin/users/user', compact('users', 'total_count'));
    }

    function user_register(Request $request){
        User::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    function delete($user_id){
        User::find($user_id)->delete();
        return back();
    }

    function profile(){
        return view('admin.users.profile');
    }

    function name_update(Request $request){
        User::find(Auth::id())->update([
            'name'=> $request->name,
        ]);
        return back()->with('name_success', 'Name Changed Successfully!!');
    }

    function password_update(Request $request){
        $request->validate([
            'old_password'=>'required',
            'password'=> ['required',  Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols(), 'confirmed'],
            'password_confirmation'=>'required',
            ]
        ,[
            // 'old_password.required'=>'old pass de!',
        ]);
        

        if(Hash::check($request->old_password, Auth::user()->password)){
            User::find(Auth::id())->update([
                'password'=> bcrypt($request->password),
            ]);
            return back()->with('pass_success', 'Password Changed Successfully!!');
        }
        else{
            return back()->with('wrong_pass','Old Pass is Wrong!!');
        }

    }
    
    function photo_update(Request $request){
        $request->validate([
            'image'=>'required|file|max:512|mimes:jpg,bmp,png,gif,webp',
        ]);

        $uploaded_photo = $request->image;
        $extension = $uploaded_photo->getClientOriginalExtension();
        $file_name = Auth::id().'.'.$extension;
        
        if(Auth::user()->image == null) {
            User::find(Auth::id())->update([
                'image'=> $file_name,
            ]);
            
            Image::make($uploaded_photo)->resize(300,300)->save(public_path('uploads/users/').$file_name);
        }
        else {
            unlink(public_path('uploads/users/').Auth::user()->image);
            
            User::find(Auth::id())->update([
                'image'=> $file_name,
            ]);
        
            Image::make($uploaded_photo)->resize(300,300)->save(public_path('uploads/users/').$file_name);
        }
        return back()->with('photo_success', 'Photo Changed Successfully!!');
    }
}