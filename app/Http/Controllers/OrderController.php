<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PDF;

class OrderController extends Controller
{
    function orders(){
        $orders = Order::all();
        return view('admin.orders.order', [
            'orders'=>$orders,
        ]);
    }

    function order_status(Request $request){
        $after_explode = explode(',', $request->status);
        $order_id = $after_explode[0];
        $status = $after_explode[1];

        Order::where('order_id', $order_id)->update([
            'status'=>$status,
        ]);
        return back();
    }

    function invoice_download($id){
        $order_info = Order::find($id);
        $data = [
            'order_id' => $order_info->order_id,
        ];
        $pdf = PDF::loadView('invoice.invoice_download', $data);
        return $pdf->download('invoice.pdf');

        // return view('invoice.invoice_download', [
        //     'order_id' => $order_info->order_id,
        // ]);
    }
}