<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;

class SubcategoryController extends Controller
{
    function subcategory(){
        $categories = Category::all();
        // $subcategories = Subcategory::all();
        $subcategories = Subcategory::orderBy('category_id', 'asc')->get();
        $trashed = Subcategory::onlyTrashed()->get();
        return view('admin.category.subcategory',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'trashed'=>$trashed,
        ]);
    }

    function subcategory_add(Request $request){
        $request->validate([
            'category_id'=>'required',
            'subcategory_name'=>'required',
            'subcategory_image'=>'required|file|max:5000|mimes:jpg,bmp,png,gif,webp',
        ]);
        
        $subcategory_id = Subcategory::insertGetId([
           'category_id'=>$request->category_id,
           'subcategory_name'=>$request->subcategory_name,
           'added_by'=>Auth::id(),
           'created_at'=>Carbon::now(),
        ]);

        $uploaded_img = $request->subcategory_image;
        $extension = $uploaded_img->getClientOriginalExtension();
        $after_replace = str_replace(' ', '-', $request->subcategory_name);
        $file_name = Str::lower($after_replace).'-'.rand(10000,19999).'.'.$extension;
        
        Image::make($uploaded_img)->resize(300,200)->save(public_path('uploads/subcategory/'.$file_name));

        Subcategory::find($subcategory_id)->update([
            'subcategory_image'=>$file_name,
        ]);

        return back()->with('add_succes', 'Subcategory Addeded Succesfully');
    }

    function subcategory_delete($subcategory_id){
        Subcategory::find($subcategory_id)->delete();
        return back()->with('delete_success', 'Subcategory Deleted Succesfully');
    }

    function subcategory_restore($subcategory_id){
        Subcategory::onlyTrashed()->find($subcategory_id)->restore();
        return back()->with('restore_success', 'Subcategory Restored Succesfully');
    }

    function subcategory_force_delete($subcategory_id){
        Subcategory::onlyTrashed()->find($subcategory_id)->forceDelete();
        return back()->with('forceDelete_success', 'Subcategory Deleted Permanently!!');
    }

    function subcategory_edit($subcategory_id){
        $categories = Category::all();
        $subcategories = Subcategory::find($subcategory_id);
        return view('admin.category.subcategory_edit',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }

    function subcategory_update(Request $request){
        $request->validate([
            'subcategory_name'=>'required',
            'subcategory_image'=>'file|max:5000|mimes:jpg,bmp,png,gif,webp',
        ]);
        
        if($request->subcategory_image == ''){
            Subcategory::find($request->subcategory_id)->update([
                'subcategory_name'=>$request->subcategory_name,
                'added_by'=>Auth::id(),
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('update_succes', 'Subategory Updated Succesfully'); 
        }
        else{
            // $category_img = Category::where('id', $request->category_id)->first()->category_image;
            $subcategory_img = Subcategory::find($request->subcategory_id)->subcategory_image;
            $delete_from = public_path('uploads/subcategory/'.$subcategory_img);
            unlink($delete_from);

            $uploaded_img = $request->subcategory_image;
            $after_replace = str_replace(' ', '-', $request->subcategory_name);
            $extension = $uploaded_img->getClientOriginalExtension();
            $file_name = Str::lower($after_replace).'-'.rand(10000,19999).'.'.$extension;
            
            Image::make($uploaded_img)->resize(300,200)->save(public_path('uploads/subcategory/'.$file_name));

            Subcategory::find($request->subcategory_id)->update([
                'subcategory_name'=>$request->subcategory_name,
                'subcategory_image'=>$file_name,
                'added_by'=>Auth::id(),
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('update_succes', 'Subategory Updated Succesfully'); 
        }
    }
}