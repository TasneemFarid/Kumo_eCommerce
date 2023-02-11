<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubcategoryController;
use App\Models\Customerlogin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;

//Frontend
Route::get('/', [FrontendController::class,"index"])->name('index');
Route::get('/product/details/{slug}', [FrontendController::class,"product_details"])->name('product_details');
Route::post('/getSize', [FrontendController::class,"getSize"]);
Route::get('/category/product/{category_id}', [FrontendController::class,"category_product"])->name('category_product');
Route::get('/about', [FrontendController::class,"about"])->name('about');
Route::get('/contact', [FrontendController::class,"contact"])->name('contact');
 
Auth::routes();

Route::get('/home', [HomeController::class, 'home'])->name('home');

//Users
Route::get('/users', [UserController::class, 'users'])->name('users');
Route::post('/user/registration', [UserController::class, 'user_register'])->name('user_register');
Route::get('/users/delete/{user_id}', [UserController::class, 'delete'])->name('delete');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/name/update', [UserController::class, 'name_update'])->name('name_update');
Route::post('/password/update', [UserController::class, 'password_update'])->name('password_update');
Route::post('/photo/update', [UserController::class, 'photo_update'])->name('photo_update');

//Category
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category_store');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'category_delete'])->name('category_delete');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category_restore');
Route::get('/category/force/delete/{category_id}', [CategoryController::class, 'category_force_delete'])->name('category_force_delete');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category_edit');
Route::post('/category/update', [CategoryController::class, 'category_update'])->name('category_update');

//Subcategory
Route::get('/subcategory', [SubcategoryController::class, 'subcategory'])->name('subcategory');
Route::post('/subcategory', [SubcategoryController::class, 'subcategory_add'])->name('subcategory_add');
Route::get('/subcategory/delete/{subcategory_id}', [SubcategoryController::class, 'subcategory_delete'])->name('subcategory_delete');
Route::get('/subcategory/restore/{subcategory_id}', [SubcategoryController::class, 'subcategory_restore'])->name('subcategory_restore');
Route::get('/subcategory/force/delete/{subcategory_id}', [SubcategoryController::class, 'subcategory_force_delete'])->name('subcategory_force_delete');
Route::get('/subcategory/edit/{subcategory_id}', [SubcategoryController::class, 'subcategory_edit'])->name('subcategory_edit');
Route::post('/subcategory/update', [SubcategoryController::class, 'subcategory_update'])->name('subcategory_update');

//Product
Route::get('/product', [ProductController::class, 'product'])->name('product');
Route::post('/product/store', [ProductController::class, 'product_store'])->name('product_store');
Route::post('/getSubcategory', [ProductController::class, 'getSubcategory']);
Route::get('/product/list', [ProductController::class, 'product_list'])->name('product_list');
Route::get('/product/inventory/{product_id}', [ProductController::class, 'add_inventory'])->name('add_inventory');
Route::post('/product/inventory/store', [ProductController::class, 'inventory_store'])->name('inventory_store');
Route::get('/product/delete/{product_id}', [ProductController::class, 'product_delete'])->name('product_delete');

//Brand
Route::get('/add/brand', [ProductController::class, 'add_brand'])->name('add_brand');
Route::post('/brand/store', [ProductController::class, 'brand_store'])->name('brand_store');

//Variation
Route::get('/product/variation', [ProductController::class, 'add_variation'])->name('add_variation');
Route::post('/add/color', [ProductController::class, 'add_color'])->name('add_color');
Route::post('/add/size', [ProductController::class, 'add_size'])->name('add_size');

//Customer Login Register 
Route::get('/customer/login/register', [FrontendController::class, 'customer_login_register'])->name('customer_login_register');
Route::post('/customer/store', [CustomerRegisterController::class, 'customer_store'])->name('customer_store');
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login'])->name('customer_login');
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer_logout');
Route::get('/customer/profile', [CustomerController::class, 'customer_profile'])->name('customer_profile');
Route::post('/customer/profile/update', [CustomerController::class, 'profile_update'])->name('profile_update');
Route::get('/customer/order', [CustomerController::class, 'customer_order'])->name('customer_order');
Route::get('/customer/email/verify/{token}', [CustomerRegisterController::class, 'customer_email_verify']);

//Cart
Route::post('/cart/store', [CartController::class, 'cart_store'])->name('cart_store');
Route::get('/cart/remove/{cart_id}', [CartController::class, 'cart_remove'])->name('cart_remove');
Route::get('/cart/clear', [CartController::class, 'cart_clear'])->name('cart_clear');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart_update');

//Wishlist
Route::get('/wishlist/remove/{wishlist_id}', [CartController::class, 'wish_remove'])->name('wish_remove');
Route::get('/wishlist/clear', [CartController::class, 'wish_clear'])->name('wish_clear');
Route::get('/wishlist/clear', [CartController::class, 'wish_clear'])->name('wish_clear');
Route::get('/wishlist', [CartController::class, 'wishlist'])->name('wishlist');

//Coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon_store');

//Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getcity']);
Route::post('/order/store', [CheckoutController::class, 'order_store'])->name('order_store');
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order_success');

//Orders
Route::get('/order', [OrderController::class, 'orders'])->name('orders');
Route::post('/order/status', [OrderController::class, 'order_status'])->name('order_status');
Route::get('/invoice/download/{id}', [OrderController::class, 'invoice_download'])->name('invoice_download');

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//Stripe
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

//Role Manager
Route::get('/role', [RoleController::class, 'role'])->name('role');
Route::post('/add/permission', [RoleController::class, 'add_permission'])->name('add_permission');
Route::post('/add/role', [RoleController::class, 'add_role'])->name('add_role');
Route::get('/edit/role/{role_id}', [RoleController::class, 'role_edit'])->name('role_edit');
Route::post('/update/role', [RoleController::class, 'update_role'])->name('update_role');
Route::post('/assign/role', [RoleController::class, 'assign_role'])->name('assign_role');
Route::get('/assign/role/delete/{user_id}', [RoleController::class, 'assign_role_delete'])->name('assign_role_delete');

//Review
Route::post('/review/store', [CustomerController::class, 'review_store'])->name('review_store');

//Password Reset
Route::get('/customer/pass/reset/req', [CustomerController::class, 'customer_pass_reset_req'])->name('customer_pass_reset_req');
Route::post('/customer/pass/reset/req/send', [CustomerController::class, 'customer_pass_reset_req_send'])->name('customer_pass_reset_req_send');
Route::get('/customer/pass/reset/form/{token}', [CustomerController::class, 'customer_pass_reset_form'])->name('customer_pass_reset_form');
Route::post('/customer/pass/reset', [CustomerController::class, 'pass_reset'])->name('pass_reset');

//Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

//Github
Route::get('/github/redirect', [GithubController::class, 'github_redirect'])->name('github_redirect');
Route::get('/github/callback', [GithubController::class, 'github_callback'])->name('github_callback');

//Google
Route::get('/google/redirect', [GoogleController::class, 'google_redirect'])->name('google_redirect');
Route::get('/google/callback', [GoogleController::class, 'google_callback'])->name('google_callback');

//Facebook
Route::get('/facebook/redirect', [FacebookController::class, 'facebook_redirect'])->name('facebook_redirect');
Route::get('/facebook/callback', [FacebookController::class, 'facebook_callback'])->name('facebook_callback');

//Contact
Route::post('/getintouch', [ContactController::class, 'get_in_touch'])->name('get_in_touch');
Route::get('/getintouch/list', [ContactController::class, 'get_in_touch_list'])->name('get_in_touch_list');
Route::get('/inbox/delete/{id}', [ContactController::class, 'inbox_delete'])->name('inbox_delete');
Route::get('/contact/info', [ContactController::class, 'contact_info'])->name('contact_info');
Route::post('/contact/update', [ContactController::class, 'contact_update'])->name('contact_update');