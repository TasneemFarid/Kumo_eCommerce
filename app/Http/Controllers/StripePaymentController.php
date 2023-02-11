<?php
    
namespace App\Http\Controllers;

use App\Models\Stripeorder;
use Session;
use Stripe;
use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Sslorder;
use Carbon\Carbon;
use App\Mail\InvoiceMail;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Str;
use Illuminate\Support\Facades\Mail;
     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $data = session('data');
        $total_pay = $data['sub_total'] + $data['charge'];
        
        $stripe_id = Stripeorder::insertGetId([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'company' => $data['company'],
            'zip' => $data['zip'],
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
            'notes' => $data['notes'],
            'payment_method' => $data['payment_method'],
            'sub_total' => $data['sub_total'],
            'discount' => $data['discount'],
            'charge' => $data['charge'],
            'total' => $data['sub_total'] + $data['charge'],
            'customer_id' => $data['customer_id'],
            'created_at' => Carbon::now(),
        ]);
        return view('frontend.stripe',[
            'data'=>$data,
            'total_pay'=>$total_pay,
            'stripe_id'=>$stripe_id,
        ]);
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $data = Stripeorder::where('id', $request->stripe_id)->get();
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
        Stripe\Charge::create ([
                "amount" => $data->first()->total * 100,
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
      
        $order_id = '#JETT'.'-'.rand(99999,1000000);
        
            Order::insert([
                'order_id'=>$order_id,
                'customer_id'=>$data->first()->customer_id,
                'subtotal'=>$data->first()->sub_total,
                'discount'=>$data->first()->discount,
                'charge'=>$data->first()->charge,
                'total'=>$data->first()->total,
                'payment_method'=>$data->first()->payment_method,
                'created_at'=>Carbon::now(),
            ]);

            BillingDetails::insert([
                'order_id'=>$order_id,
                'customer_id'=>$data->first()->customer_id,
                'name'=>$data->first()->name,
                'email'=>$data->first()->email,
                'company'=>$data->first()->company,
                'phone'=>$data->first()->phone,
                'address'=>$data->first()->address,
                'zip'=>$data->first()->zip,
                'country_id'=>$data->first()->country_id,
                'city_id'=>$data->first()->city_id,
                'notes'=>$data->first()->notes,
                'created_at'=>Carbon::now(),
            ]);

            $carts = Cart::where('customer_id', $data->first()->customer_id)->get();
            foreach($carts as $cart){
                OrderProduct::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>$data->first()->customer_id,
                    'product_id'=>$cart->product_id,
                    'price'=>$cart->rel_to_product->after_discount,
                    'color_id'=>$cart->color_id,
                    'size_id'=>$cart->size_id,
                    'quantity'=>$cart->quantity,
                    'created_at'=>Carbon::now(),
                ]);
                
                Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
            }
            
            Mail::to($data->first()->email)->send(new InvoiceMail($order_id));

            $customer_id = $data->first()->customer_id;

            //SMS
            // $url = "https://bulksmsbd.net/api/smsapi";
            // $api_key = "ZNJ8X0SwPhO5mZanZVrE";
            // $senderid = "tasneemfarid";
            // $number = $data->first()->phone;
            // $message = "Congratulations! Order placed. Total Amount: TK ".$request->sub_total+$request->charge;
        
            // $data = [
            //     "api_key" => $api_key,
            //     "senderid" => $senderid,
            //     "number" => $number,
            //     "message" => $message
            // ];
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // $response = curl_exec($ch);
            // curl_close($ch);
            // return $response;
            
            Cart::where('customer_id', $customer_id)->delete();

            return redirect()->route('order_success')->withOrder($order_id);
    }
}