<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;

class CategoryController extends Controller
{
    function category(){
        $category_info = Category::all();
        $trashed = Category::onlyTrashed()->get();
        return view('admin.category.category',[
            'categories'=> $category_info,
            'trashed'=> $trashed,
        ]);
    }

    function category_store(CategoryRequest $request) {
        $category_id = Category::insertGetId([
            'category_name'=>$request->category_name,
            'added_by'=>Auth::id(),
            'created_at'=>Carbon::now(),
        ]);

        $uploaded_photo = $request->category_image;
        $extension = $uploaded_photo->getClientOriginalExtension();
        $after_replace = str_replace(' ', '-', $request->category_name);
        $cat_image_name = Str::lower($after_replace).'.'.$extension;
        
            Category::find($category_id)->update([
                'category_image'=> $cat_image_name,
            ]);
            
            Image::make($uploaded_photo)->resize(300,200)->save(public_path('uploads/category/').$cat_image_name);

        return back()->with('add_success', 'Category Added Suuccesfully');
    }

    function category_delete($category_id){
        Category::find($category_id)->delete();
        return back()->with('delete_success', 'Category Deleted Suuccesfully');
    }

    function category_restore($category_id){
        Category::onlyTrashed()->find($category_id)->restore();
        return back();
    }

    function category_force_delete($category_id){
        // $category_img = Category::onlyTrashed()->where('id', $category_id)->first()->category_image;
        $category_img = Category::onlyTrashed()->find($category_id)->category_image;
        unlink(public_path('uploads/category/'.$category_img));

        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back()->with('force_delete_success', 'Category Deleted Suuccesfully');
    }

    function category_edit($category_id){
        $category_info = Category::find($category_id);
        return view('admin.category.category_edit',[
            'category_info' => $category_info,
        ]);
    }

    function category_update(Request $request){
        if($request->category_image == ''){
            Category::find($request->category_id)->update([
                'category_name'=>$request->category_name,
                'added_by'=>Auth::id(),
                'updated_at'=>Carbon::now(),
            ]);
            return back(); 
        }
        else{
            // $category_img = Category::where('id', $request->category_id)->first()->category_image;
            $category_img = Category::find($request->category_id)->category_image;
            $delete_from = public_path('uploads/category/'.$category_img);
            unlink($delete_from);

            $uploaded_img = $request->category_image;
            $after_replace = str_replace(' ', '-', $request->category_name);
            $extension = $uploaded_img->getClientOriginalExtension();
            $file_name = Str::lower($after_replace).'-'.rand(10000,19999).'.'.$extension;
            
            Image::make($uploaded_img)->resize(300,200)->save(public_path('uploads/category/'.$file_name));

            Category::find($request->category_id)->update([
                'category_name'=>$request->category_name,
                'category_image'=>$file_name,
                'added_by'=>Auth::id(),
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('update_succes', 'Category Updated Suuccesfully'); 
        }
    }
}