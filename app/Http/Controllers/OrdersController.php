<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\User;
use Session;
use Auth;
use Mail;
use DB;

class OrdersController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }

    public function index(){

      $orders = Auth::user()->orders()->orderBy('id','desc')->get();
      return view('orders.index')->with('orders', $orders);
    }

    public function store_order(Request $request){

      $this->validateWith([
        'name' => 'required',
        'phone' => 'required|numeric',
        'address' => 'required'
      ]);

      $user = User::find($request->user_id);

      // if ($user->profile) {
      //   session(['uemail' => $user->profile->email]);
      // }else{
      //   session(['uemail' => $user->email]);
      // }
      
      $order = new Orders;

      $order->product_id = $request->product_id;
      $order->user_id = $request->user_id;
      $order->name = $request->name;
      $order->user_email = $request->user_email;
      $order->phone = $request->phone;
      $order->address = $request->address;

      $order->save();

      // try {
      //   Mail::send('emails.orders.shipped', 
      //             [ 
      //               'user_name' => $user->name, 
      //               'clientname' => $request->name,
      //             ]
      //             , function ($message)
      //               {

      //                   $message->from('sastoshowroom@gmail.com', 'Sastoshowroom');
      //                   $message->cc('sastoshowroom@gmail.com', $name = null);
      //                   $message->subject('Order Alert! Sastoshowroom');
      //                   $message->to(session()->get('uemail'));

      //               });
      // } catch (Exception $e) {
        
      // }

      //Php Mail
        // $to = $user->email;
        // $subject = "Order Alert!";

        // $txt = $user->name . " जी,<br><br>" . $request->name . " द्वारा तपाईंको समानको अर्डर भएको छ कृपया <a href='https://sastoshowroom.com/' />Sastoshowroom.com</a> मा लगिन गरेर हेर्नुहोस् <br>धन्यवाद |<br>  Regards, <br>Sastoshowroom Team.";

        // // Always set content-type when sending HTML email
        // $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        // $headers .= "From: sastoshowroom@gmail.com" . "\r\n";
        // $headers .= "CC: nickarsenal007@gmail.com"."\r\n";

        // mail($to,$subject,$txt,$headers);

      Session::flash('success', 'Thanks for placing your order. We will get back to you soon.');
      // return redirect()->route('view.product', $request->product_id);
      return redirect()->back();

    }

    public function boosted_orders(){
      $orders = DB::table('boost_orders')->orderBy('id', 'desc')->get();
      return view('admin.boost_orders')->withOrders($orders);
    }
}
