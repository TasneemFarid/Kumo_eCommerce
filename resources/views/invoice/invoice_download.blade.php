<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 2</title> 
    <style>
        /* @page { size: 25cm 20cm portrait; } */
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap');

.clearfix:after {
/* align-content: center; */
  /* content: "";
  display: table;
  clear: both; */
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  font-family: 'Open Sans', sans-serif;
  position: relative;
  width: 18cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-size: 14px; 
  font-weight: 400 !important;
}

header {
  padding: 10px 0;
  margin-bottom: 80px;
  /* border-bottom: 1px solid #AAAAAA; */
}

main{
    padding-top: 20px;
    border-top: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  /* border-left: 6px solid rgb(240, 37, 37); */
  float: left;
}

#client .to {
  color: rgb(240, 37, 37);
}
.tags {
  color: rgb(240, 37, 37);
}

h2.name {
  font-size: 21px;
  font-weight: normal;
  margin: 0;
  color: #777777;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: rgb(240, 37, 37);
  font-size: 14px;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 14px;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-top: 150px;
  margin-bottom: 20px;
}

table th,
table td {
  padding: 20px;
  background: #EEEEEE;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}

table td {
  text-align: right;
}

table td h3{
  color: rgb(240, 37, 37);
  font-size: 14px;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 14px;
  background: rgb(240, 37, 37);
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: rgb(240, 37, 37);
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 14px;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 14px;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: rgb(240, 37, 37);
  font-size: 14px;
  border-top: 1px solid rgb(240, 37, 37); 

}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 14px;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  /* border-left: 6px solid rgb(240, 37, 37);  */
  color: rgb(240, 37, 37);
}

#notices .notice {
  font-size: 14px;
  color: #777777;
}

/* footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  margin-top: 100px;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
} */
    </style>
    
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img width="100" src="https://i.postimg.cc/L8NwbXNL/logo.png">
      </div>
      <div id="company">
        <h1 class="name" style="color: rgb(240, 37, 37)">Invoice</h1>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to"><b>INVOICE TO:</b></div>
          <div class="name">{{App\Models\BillingDetails::where('order_id', $order_id)->first()->name}}</div>
          <br>
          <div class="tags"><b>BILLING INFORMATION</b></div>
          <div class="email"><b>T:</b> 0{{App\Models\BillingDetails::where('order_id', $order_id)->first()->phone}}</div>
          <div class="email"><b>Email:</b> {{App\Models\BillingDetails::where('order_id', $order_id)->first()->email}}</div>
          <div class="address"><b>Address:</b> {{App\Models\BillingDetails::where('order_id', $order_id)->first()->address}}</div>
        </div>
        <div id="invoice">
          <div class="date"><b>Order ID:</b> {{$order_id}}</div>
          <div class="date"><b>Order Date:</b> {{App\Models\BillingDetails::where('order_id', $order_id)->first()->created_at->format('d-M-Y')}}</div>
          <br>
          <div class="tags"><b>PAYMENT METHOD</b></div>
          <div class="email"><b>Method:</b> 
            @php
                $pm = App\Models\Order::where('order_id', $order_id)->first()->payment_method;
                if($pm == 1){
                echo "Cash";
                }
                else if($pm == 2){
                echo "SSL Commerz";
                }
                else{
                echo "Stripe";
                }
                @endphp
          </div>
          <div class="email"><b>Card Type:</b> @php
            $pm = App\Models\Order::where('order_id', $order_id)->first()->payment_method;
            if($pm == 1){
              echo "NA";
            }
            else if($pm == 2){
              echo "SSL Commerz";
            }
            else{
              echo "Stripe";
            }
            @endphp</div>
          <div class="address"><b>Transaction ID:</b> 
            @php
            $pm = App\Models\Order::where('order_id', $order_id)->first()->payment_method;
            if($pm == 1){
              echo "NA";
            }
            else if($pm == 2){
              echo "SSL Commerz";
            }
            else{
              echo "Stripe";
            }
            @endphp</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">Item</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">UNIT PRICE</th>
            <th class="qty">QUANTITY</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
            @php
            $sub = 0;
            @endphp
            @foreach (App\Models\OrderProduct::where('order_id', $order_id)->get() as $sl=>$order_product)
            <tr>
                <td class="no">{{$sl+1}}</td>
                <td class="desc"><h3>{{$order_product->rel_to_product->rel_to_cat->category_name}}</h3>{{$order_product->rel_to_product->product_name}}</td>
                <td class="unit">TK {{$order_product->rel_to_product->after_discount}}</td>
                <td class="qty">{{$order_product->quantity}}</td>
                <td class="total">TK {{$order_product->rel_to_product->after_discount*$order_product->quantity}}</td>
              </tr>
              @php
              $sub += $order_product->rel_to_product->after_discount*$order_product->quantity;
              @endphp
              @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">SUBTOTAL</td>
            <td>TK {{$sub}}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">Discount</td>
            <td>TK {{App\Models\Order::where('order_id', $order_id)->first()->discount}}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">Delivery Charge</td>
            <td>TK {{App\Models\Order::where('order_id', $order_id)->first()->charge}}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2"><b>GRAND TOTAL</b></td>
            <td><b>TK {{App\Models\Order::where('order_id', $order_id)->first()->total}}</b></td>
          </tr>
        </tfoot>
      </table>
      <div id="thanks">Thank you!</div>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    {{-- <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer> --}}
  </body>
</html>