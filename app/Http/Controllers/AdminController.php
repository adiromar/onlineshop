<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Orders;
use App\Order;
use App\OrderNew;
use App\OrderDetail;
use App\User;
use App\Delivery;
use Auth;
use DB;
use Session;

class AdminController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }

    public function featured(){

        return view('admin.featured');
    }

    public function deal_of_week(){

      return view('admin.deal_of_week');
  }

    public function unmake_featured(){

      Product::where('id', request()->notfeatured )->update([ 'featured' => 0 ]);
      session()->flash('success', 'Success');
      return redirect()->back();
    }

    public function make_featured(Request $request){

    	$this->validateWith([
    			'featured' => 'required',
    	]);

    	Product::where('id', $request->featured )->update([ 'featured' => 1 ]);

        session()->flash('success', 'Success');
        return redirect()->back();
    }

    public function make_deal_of_week(Request $request){

    	$this->validateWith([
          'deal_of_week' => 'required',
          'offer_time' => 'required',
    	]);

    	Product::where('id', $request->deal_of_week )->update([ 'deal_of_week' => 1 ,'dow_datetime' => $request->offer_time]);

        session()->flash('success', 'Success ! Deal of Week Updated');
        return redirect()->back();
    }

    public function unmake_deal_of_week(){

      Product::where('id', request()->not_deal )->update([ 'deal_of_week' => 0 ]);
      session()->flash('success', 'Success');
      return redirect()->back();
    }

    public function get_all_orders(){

      if(Auth::user()->hasRoles('admin')){
        $orders = Orders::orderBy('id', 'desc')->with('product')->get();
      }elseif(Auth::user()->hasRoles('supplier')){
        // $th = Auth::user()->assign_theme;
        $orders = Orders::orderBy('id', 'desc')->with('product')->get();
      }else{
        $orders = Orders::orderBy('id', 'desc')->with('product')->get();
      }
      return view('admin.orders')->with('orders', $orders);
    }

  public function get_all_orders_new(){
    $userid = Auth::user()->id;
    
    $orders = Order::whereRaw('json_contains(merchantId, \'["'.$userid.'"]\')')->latest()
    // whereRaw('json_contains(merchantId, \'["'.$userid.'"]\')')->latest()
      ->join('payment_details', 'payment_details.payment_id', '=', 'orders.payment_details_id')
      ->where('payment_details.status', '0')
      ->where('orders.order_status', '1')->orwhere('orders.order_status', '2')
      ->orderBy('order_date')
      ->get();
      // dd($orders);
      return view('admin.orders_new')->with('orders', $orders);
    }

    public function get_all_paid_orders(){
      $title = 'All Paid Orders';
      $orders = Order::latest()
      ->join('payment_details', 'payment_details.payment_id', '=', 'orders.payment_details_id')
      ->where('payment_details.status', '1')
      ->where('orders.order_status', '1')
      ->orderBy('order_date')->get();

      return view('admin.paidOrders')->with('orders', $orders)->with('title', $title);
    }

    public function get_all_cancelled(){
      $title = 'All Cancelled Orders';
      $orders = Order::latest()
      ->join('payment_details', 'payment_details.payment_id', '=', 'orders.payment_details_id')
      // ->where('payment_details.status', '1')
      ->where('orders.order_status', '0')
      ->orderBy('order_date')->get();

      return view('admin.paidOrders')->with('orders', $orders)->with('title', $title);
    }

    public function suspend_users(){
      $customers = User::whereHas('roles' , function($query){
        $query->where('role', 'Guest');
      })->get();

      $suppliers = User::whereHas('roles' , function($query){
        $query->where('role', 'Supplier');
      })->get();

      $deliveryusers = User::whereHas('roles' , function($query){
        $query->where('role', 'Delivery');
      })->get();

      return view('admin.suspend_users', compact('customers', 'suppliers', 'deliveryusers'));
    }

    public function make_user_suspend(Request $request){

      if (empty($request->user_ids)) {

        User::where('suspend', '1')->update(['suspend' => 0]);

        session()->flash('success', 'Succesfull');
        return redirect()->back();
      }

      User::whereIn('id', $request->user_ids )->update([ 'suspend' => 1 ]);
      User::whereNotIn('id', $request->user_ids )->update([ 'suspend' => 0 ]);

      session()->flash('success', 'Succesfull');
      return redirect()->back();

    }

    public function clientThemeAssign(){
      // $user->roles()->first()->id;
      $users = User::with('roles')->join('role_user', 'role_user.user_id', '=', 'users.id')->where('role_user.role_id', '2')->get();
      $users1 = User::orderBy('id','desc')->get();

      return view('admin.client_theme_assign')->with('users', $users)->with('users1', $users1);
  }

  public function make_theme_assign(Request $request){

    $this->validateWith([
        'theme_assign' => 'required',
        'user_id' => 'required',
    ]);

    User::where('id', $request->user_id )->update([ 'assign_theme' => $request->theme_assign ]);

      session()->flash('success', 'Success ! Theme Assigned to User Successfully');
      return redirect()->back();
  }

  public function due_billing(){
    $title = 'Due Billing Amount';
    $bill = DB::table('due_bill')->get();
    return view('admin.due_bill')->with('bill', $bill)->with('title', $title);
  }

  public function add_delivery_user() {

    return view('user.add-delivery-man');

  }

  public function store_delivery_user(Request $request) {

    $this->validateWith([
      'username' => 'required',
      'email' => 'required|unique:users',
      'password' => 'required|string|min:6|confirmed',
      'supplier_id' => 'required'
    ]);

    $user = User::create([
      'username' => $request->username,
      'email' => $request->email,
      'password' => bcrypt($request->password)
    ]);

    $uid = $user->id;

    DB::table('role_user')->insert([
        'user_id' => $uid,
        'role_id' => 4,
    ]);

    $data = new Delivery;
    $data->user_id = $uid;
    $data->supplier_id = $request->supplier_id;

    $data->save();

    Session::flash('success', 'Succesfully added a delivery user. Please inform them with username and password');

    return redirect()->route('delivery.users');

  }

  public function update_delivery_user($id, Request $request) {

    $this->validateWith([
      'username' => 'required',
      'email' => 'required',
      'supplier_id' => 'required',
    ]);

    $duser = Delivery::findOrFail($id);

    $user = $duser->user;

    $user->username = $request->username;
    $user->email = $request->email;
    if ( isset($request->password) ) {
      $user->password = bcrypt($request->password);
    }

    $user->save();

    Session::flash('success', 'Succesfully updated. Please inform them with new change.');

    return redirect()->route('delivery.users');

  }

  public function index_delivery_users() {

    $deliveryusers = User::whereHas('roles' , function($query){
      $query->where('role', 'Delivery');
    })->get();

    return view('user.deliveryusers', compact('deliveryusers'));

  }

  public function suspend_delivery_user($id) {

    $user = User::findOrFail($id);

    if ( $user->suspend == 0 ) {
      $user->suspend = 1;
    }else{
      $user->suspend = 0;
    }

    $user->save();

    return redirect()->back();

  }

  public function edit_delivery_user($id) {

    $deliveryuser = User::findOrFail($id);

    return view('user.edit-delivery-user', compact('deliveryuser'));

  }

  public function assign_delivery(Request $request) {

    $this->validateWith([
      'assign_delivery_to' => 'required',
      'order_id' => 'required'
    ]);


    DB::table('delivery_assigned')->insert([
      'user_id' => $request->assign_delivery_to,
      'order_id' => $request->order_id,
      'supplier_id' => $request->supplier_id,
    ]);

    Session::flash('success', 'Succesfully assigned.');

    return redirect()->back();

  }

}
