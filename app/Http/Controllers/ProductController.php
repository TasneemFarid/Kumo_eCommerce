<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductThumb;
use App\Models\Size;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;

class ProductController extends Controller
{
    function product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        return view('admin.product.product',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brands,
        ]);
    }

    function getSubcategory(Request $request){
        $str = '<option value="">--Select Subcategory--</option>';
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();

        foreach ($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }

        echo $str;
    }

    function product_store(Request $request){
        $product_id = Product::insertGetId([
           'category_id'=>$request->category_id, 
           'subcategory_id'=>$request->subcategory_id, 
           'product_name'=>$request->product_name, 
           'price'=>$request->price, 
           'discount'=>$request->discount, 
           'after_discount'=>$request->price - ($request->price * $request->discount / 100), 
           'brand'=>$request->brand, 
           'short_desp'=>$request->short_desp, 
           'long_desp'=>$request->long_desp, 
           'slug'=>str_replace(' ', '-', Str::lower($request->product_name)).'-'.rand(1000000,1999999), 
           'created_at'=>Carbon::now(), 
        ]);

        $uploaded_img = $request->preview;
        $extension = $uploaded_img->getClientoriginalExtension();
        $file_name = str_replace(' ', '-', Str::lower($request->product_name)).'-'.rand(10000,19999).'.'.$extension;
        Image::make($uploaded_img)->resize(623, 800)->save(public_path('uploads/product/preview/'.$file_name));

        Product::find($product_id)->update([
            'preview'=>$file_name,
        ]);  

        $thumb_img = $request->thumbnail;
        foreach ($thumb_img as $thumbnail) {
            $thumb_extension = $thumbnail->getClientoriginalExtension();
            $thumb_name = str_replace(' ', '-', Str::lower($request->product_name)).'-'.rand(10000,19999).'.'.$thumb_extension;
            Image::make($thumbnail)->resize(623, 800)->save(public_path('uploads/product/thumbnail/'.$thumb_name));

            ProductThumb::insert([
                'product_id'=>$product_id,
                'thumbnail'=>$thumb_name,
            ]); 
        };

        return back();
    }

    function product_list(){
        // $products = Product::all();
        $products = Product::orderBy('category_id', 'asc')->get();
        return view('admin.product.product_list', [
            'products'=>$products,
        ]);
    }

    function add_inventory($product_id){
        $product = Product::find($product_id);
        $colors = Color::all();
        $sizes = Size::all();
        $inventories = Inventory::where('product_id', $product_id)->get();
        return view('admin.product.inventory',[
            'product'=>$product,
            'colors'=>$colors,
            'sizes'=>$sizes,
            'inventories'=>$inventories,
        ]);
        return back();
    }

    function inventory_store(Request $request){
        if(Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
            Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back();
        }
        else{
            Inventory::insert([
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
            ]);
            return back();
        }
    }
    
    function add_variation(){
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product.variation',[
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }

    function add_color(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
        ]);
        return back()->with('color_success','Color added successfully!');
    }

    function add_size(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
        ]);
        return back()->with('size_success','Size added successfully!');
    }

    function product_delete($product_id){
        $prev_img = Product::where('id', $product_id)->get()->first()->preview;
        unlink(public_path('uploads/product/preview/'.$prev_img));
        Product::find($product_id)->delete();
        
        $thumbs = ProductThumb::where('product_id', $product_id)->get();
        foreach ($thumbs as $thumb) {
            unlink(public_path('uploads/product/thumbnail/'.$thumb->thumbnail));
            ProductThumb::find($thumb->id)->delete();
        }

        $inventories = Inventory::where('product_id', $product_id)->get();
        foreach($inventories as $inventory){
            Inventory::find($inventory->id)->delete();
        }

        return back()->with('delete_success','Product Deleted Successfully!');
    }

    function add_brand(){
        $brands = Brand::all();
        return view('admin.product.add_brand',[
            'brands'=>$brands,
        ]);
    }

    function brand_store(Request $request){
        
        $uploaded_file = $request->brand_logo;
        
        if($uploaded_file == ''){
            Brand::insert([
            'brand_name'=>$request->brand_name,
        ]);
        }
        else{
            $extension = $uploaded_file->getClientOriginalExtension();
            $file_name = Str::lower($request->brand_name).'.'.$extension;
            Brand::insert([
                'brand_name'=>$request->brand_name,
                'brand_logo'=>$file_name,
            ]);
            Image::make($uploaded_file)->resize(300, 300)->save(public_path('uploads/brand/'.$file_name));
        }
        return back();
    }
}