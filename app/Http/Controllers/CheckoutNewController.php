<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;

use App\Order;
use App\OrderDetail;
use App\Product;

use App\OrderNew;
use App\OrderDetailNew;
use App\ShippingDetail;
use App\User;
use Mail;
use DB;
use Auth;
use Cart;

class CheckoutNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('theme1.checkout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        dd($request);
        if ( $request->saved_shipping_detail != 1 ) {
            $this->validateWith([
                'username' => 'required',
                'shippingAddress' => 'required',
                'user_email' => 'required',
                'city' => 'required',
                'phoneNumber' => 'required',
                'product_id' => 'required',
            ]);
        }

        $productids = $request->product_id;
        $supplierids = $request->supplier_id;
        $product_rate = $request->rate;

        $data = '';
        $orderId = 0;
        $returnid = 0;
        $uniqueOrderIdentifier = str_random(18);

        try {

            if ( $request->saved_shipping_detail ) {

                $shippingdetail = ShippingDetail::find($request->saved_shipping_detail);

                $returnid = $request->saved_shipping_detail;

            }else{

              $returnid = DB::table("shipping_details")->insertGetId([
                    'email' => $request->user_email,
                    'client_name' => $request->full_name,
                    'address' => $request->shippingAddress,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zipcode' => $request->zipcode,
                    'phone' => $request->phoneNumber,
                    'alternatePhone' => $request->alternatePhone,
                    'shipping_type_id' => $request->shippingTypeId,
                    'customer_id' => $request->orderedBy,
                    'near_by_places' => $request->near_by_places,
                ]);

            }
            // Cash on delivery = 1 Khalti = 2
            $paymentid = DB::table("payment_details")->insertGetId([
                'payment_method_id' => 1,
                'amount' => $request->shippingCost,
                'payment_date' => null,
                'status' => 0,
            ]);

        } catch (Exception $exception) {
            $errormessage = $exception->getMessage();
        }

        try {

            // Order
            $order = new Order;

            // $order->order_date = date('Y-m-d', strtotime($request->orderDate));
            $order->order_date = date('Y-m-d');
            $order->shipping_details_id = $returnid;
            $order->payment_details_id = $paymentid;
            // $order->order_status = $request->orderStatus;
            $order->ordered_by = $request->orderedBy;
            $order->unique_order_identifier = $uniqueOrderIdentifier;
            $order->shippingCost = $request->shippingCost;

            // for saving multiple vendor id,
            $product_Ids = $request->product_id;
            $tmp = '';
            foreach ($product_Ids as $pro) {
                $lists[] = $pro;
                $tmp .= $pro . ',';
            }
            $tmp = trim($tmp, ','); 
            
            // $order->merchantId = $tmp;
            $order->merchantId = json_encode($request->product_id);
            $order->save();

            $orderId = $order->id;

        } catch (Exception $exception) {
            $errormessage = $exception->getMessage();

            // return $this->jsonResponse($data, 404, $errormessage);
        }

        try {

            $productIds = $request->product_id;
            $quantities = $request->quantities;

            if ( $productIds && $quantities ) {
                $comb = array_combine($productIds, $quantities);

                foreach ($comb as $p => $q) {
                    $prod = Product::find($p);
                    // Order Details
                    $OrderDetail = new OrderDetail;

                    $OrderDetail->product_id = $p;
                    $OrderDetail->order_id = $orderId;
                    $OrderDetail->quantity = $q;
                    $OrderDetail->rate = $prod->rate;

                    $OrderDetail->save();

                    if($OrderDetail){
                        // $pd = new Product;
                        $tsq = $q + 1;
                        $qty = $prod->quantity;
                        $qty = $qty - $q;
                        $upd = Product::where('id', $p)->update(
                            [
                                'totalSoldQuantity'=> $tsq,
                                'availableItems' => $qty,
                                'quantity' => $qty
                            ]);
                    }

                }

            }

            Cart::destroy();

        } catch (Exception $exception) {
            $errormessage = $exception->getMessage();
        }



        session()->flash('info', 'Thank you for placing your orders. We will contact you soon.');
        return redirect('/order-success');
    }


    public function update_payment_status(Request $request){
        // dd($request);
        // OrderNew::where('id', $request->order_id )->update([ 'paymentStatus' => $request->payment_Status, 'paymentDate' => date("Y-m-d") ]);

        DB::table('payment_details')->where('payment_id', $request->order_id )->update([ 'status' => $request->payment_Status, 'payment_date' => date("Y-m-d") ]);

        session()->flash('info', 'Payment Status Updated');
        return redirect()->back();
    }

    public function update_order_status(Request $request){
        // dd($request);
        // OrderNew::where('id', $request->order_id )->update([ 'paymentStatus' => $request->payment_Status, 'paymentDate' => date("Y-m-d") ]);

        $up = Order::where('id', $request->order_id )->update([ 'order_status' => $request->order_status ]);
        if($up){
            session()->flash('info', 'Order Status Updated');
            return redirect()->back();
        }else{
            session()->flash('info', 'Error Occurred while updating');
            return redirect()->back();
        }

    }

    public function store_khalti(Request $request)
    {
        // dd($request);die;
        // echo $request->username;
        $this->validateWith([
            'username' => 'required',
            'shippingAddress' => 'required',
            'user_email' => 'required',
            'number' => 'required',
            'product_id' => 'required'
        ]);

        $productids = $request->product_id;
        $supplierids = $request->supplier_id;
        $product_rate = $request->rate;

        $data = '';
        $orderId = 0;
        $returnid = 0;
        $uniqueOrderIdentifier = str_random(18);

        try {

            // Add shipping details
            // if ( $request->shippingAddress ) {

                // $shippingAddress = (object) $request->shippingAddress;

                $returnid = DB::table("shipping_details")->insertGetId([
                    'email' => $request->user_email,
                    'client_name' => $request->full_name,
                    'address' => $request->shippingAddress,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zipcode' => $request->zipcode,
                    'phone' => $request->number,
                    'shipping_type_id' => $request->shippingTypeId,
                    'customer_id' => $request->orderedBy,
                ]);

            // }

            $paymentid = DB::table("payment_details")->insertGetId([
                'payment_method_id' => 1,
                'amount' => $request->amount,
                'status' => 1,
            ]);

        } catch (Exception $exception) {
            $errormessage = $exception->getMessage();
        }

        try {

            // Order
            $order = new Order;

            // $order->order_date = date('Y-m-d', strtotime($request->orderDate));
            $order->order_date = date('Y-m-d');
            $order->shipping_details_id = $returnid;
            $order->payment_details_id = $paymentid;
            // $order->order_status = $request->orderStatus;
            $order->ordered_by = $request->orderedBy;
            $order->unique_order_identifier = $uniqueOrderIdentifier;

            $order->save();

            $orderId = $order->id;

        } catch (Exception $exception) {
            $errormessage = $exception->getMessage();

            // return $this->jsonResponse($data, 404, $errormessage);
        }

        try {

            $productIds = $request->product_id;
            $quantities = $request->quantities;

            if ( $productIds && $quantities ) {
                $comb = array_combine($productIds, $quantities);

                foreach ($comb as $p => $q) {
                    $rates = Product::find($p);
                    // Order Details
                    $OrderDetail = new OrderDetail;

                    $OrderDetail->product_id = $p;
                    $OrderDetail->order_id = $orderId;
                    $OrderDetail->quantity = $q;
                    $OrderDetail->rate = $rates->rate;

                    $OrderDetail->save();
                }
            }
        } catch (Exception $exception) {
            $errormessage = $exception->getMessage();
        }

        session()->flash('info', 'Thank you for placing your orders. We will contact you soon.');
        return redirect('/order-success');
    }


    public function verifyKhaltiPayment(Request $request){
        $args = http_build_query(array(
          'token' => $request->token,
          'amount'  => $request->amount
        ));

      $url = "https://khalti.com/api/payment/verify/";

      # Make the call using API.
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $headers = ['Authorization: Key test_secret_key_bda93b06439c41be99f5e8c4f8cb49bc'];
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      // Response
      $response = curl_exec($ch);
      $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);


      $content = new Request();
        $content->full_name = $request->full_name;
        $content->username = $request->username;
        $content->shippingAddress = $request->shippingAddress;
        $content->user_email = $request->user_email;
        $content->number = $request->number;

        $content->state = $request->state;
        $content->city = $request->city;
        $content->zipcode = $request->zipcode;

        $content->product_id = $request->product_id;
        $content->rate = $request->rate;
        $content->supplier_id = $request->supplier_id;
        $content->quantities = $request->quantities;

        $content->orderedBy = $request->orderedBy;
        $content->shipmethod = $request->shipmethod;

        $content->amount = $request->amount;
        $this->store_khalti($content);


  }





    public function order_success()
    {
        $title = 'Order Success';
        return view('theme5.order_success')->with('title', $title);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
