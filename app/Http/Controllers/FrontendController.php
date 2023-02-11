<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Contactinfo;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductThumb;
use Illuminate\Http\Request;
use App\Models\Size;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Arr;

class FrontendController extends Controller
{ 
    function index(){
        $categories = Category::withTrashed()->get();
        // $products = Product::take(8)->get();
        $products = Product::inRandomOrder()->take(8)->get();
        $feat_products = Product::latest()->take(3)->get();
        $top_selling_products = OrderProduct::groupBy('product_id')->selectraw('sum(quantity) as sum, product_id')->havingRaw('sum >= 5')->take(3)->get();
        $reviews = OrderProduct::where('review', '!=', null)->get();
        
        //Cookie
        $recently_viewed_products = json_decode(Cookie::get('recent_view'), true);
        if($recently_viewed_products == null){
            $recently_viewed_products = [];
            $after_unique = array_unique($recently_viewed_products);
        }
        else{
            $after_unique = array_unique($recently_viewed_products);
        }
        $recently_viewed_products = Product::find($after_unique);
        
        return view('frontend.index',[
            'categories'=>$categories,
            'products'=>$products,
            'feat_products'=>$feat_products,
            'top_selling_products'=>$top_selling_products,
            'recently_viewed_products'=>$recently_viewed_products,
            'reviews'=>$reviews,
        ]);
    }

    function about(){
        return view('frontend.about');
    }

    function contact(){
        $contacts = Contactinfo::find('1');
        return view('frontend.contact',[
            'contacts'=>$contacts,
        ]);
    }

    function product_details($slug){
        $product_info = Product::where('slug', $slug)->get();
        $thumbnails = ProductThumb::where('product_id', $product_info->first()->id)->get();
        $related_products = Product::where('category_id', $product_info->first()->category_id)->where('id','!=',$product_info->first()->id)->get();
        $available_colors = Inventory::where('product_id', $product_info->first()->id)->groupBy('color_id')->selectraw('count(*) as total, color_id')->get();
        // $available_sizes = Inventory::where('product_id', $product_info->first()->id)->first()->size_id;
        $sizes = Size::all();
        $reviews = OrderProduct::where('product_id', $product_info->first()->id)->where('review', '!=', null)->get();
        $total_review = OrderProduct::where('product_id', $product_info->first()->id)->where('review', '!=', null)->count();
        $total_star = OrderProduct::where('product_id', $product_info->first()->id)->where('review', '!=', null)->sum('star');

        //Recently Viewed
        $product_id = $product_info->first()->id;
        $all = Cookie::get('recent_view');
        if(!$all){
            $all = "[]";
        }
        $all_info = json_decode($all, true);
        $all_info = Arr::prepend($all_info, $product_id);
        $recent_product_id = json_encode($all_info);

        Cookie::queue('recent_view', $recent_product_id, 1000);
        
        return view('frontend.details',[
            'product_info'=>$product_info, 
            'thumbnails'=>$thumbnails,
            'related_products'=>$related_products,
            'available_colors'=>$available_colors,
            // 'available_sizes'=>$available_sizes,
            'sizes'=>$sizes,
            'reviews'=>$reviews,
            'total_review'=>$total_review,
            'total_star'=>$total_star,
        ]);
    }

    function getSize(Request $request){
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        $str = '';
        foreach($sizes as $size){
            $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                        <input class="form-check-input" value="'.$size->size_id.'" type="radio" name="size_id" id="size'.$size->size_id.'">
                        <label class="form-option-label" for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
                    </div>';
        }
        echo $str;
    }

    function customer_login_register(){
        return view('frontend.login');
    }

    function category_product($category_id){
        $category = Category::find($category_id);
        $category_products = Product::where('category_id', $category_id)->get();
        return view('frontend.category_product',[
            'category'=>$category,
            'category_products'=>$category_products,
        ]);
    }
    
}