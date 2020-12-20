<?php

namespace App\Http\Controllers\Theme5;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;
use App\Setting;
use App\Category;
use App\Tags;
use Auth;
use App\User;
use App\Order;
use App\Supplier;
use App\Brand;
use App\ShippingDetail;
use App\Profile;
use App\Delivery;
use Session;
use DB;
use Illuminate\Support\Str;

use App\Mail\VerifyEmail;

class FrontController extends Controller
{

    public function index() {
        $title = 'Chaiyo | Shop Products Online';
        $products = Product::where('featured', 0)
            ->orderBy('products.id','desc')->take(20)->get();

        $featured_products = Product::notsuspended()->where('products.featured',1)
            ->orderBy('products.updated_at','desc')->take(12)->get();

        $setting = Setting::first();
        $previewEdit = 0;
        $categories = Category::orderBy('name')->get();
        $tags = Tags::orderBy('name')->get();
        $brands = Brand::latest()->get();

        $parentc = Category::where('parentId', '>', '0')->get()->pluck('parentId', 'parentId')->toArray();
        $parent = Category::wherein('id', $parentc)->get()->take(6);

        return view('theme5.index', compact('title', 'previewEdit', 'categories','featured_products','products','tags','brands','parent'));

  }

  public function previewEdit() {
    $title = 'Chaiyo | Shop Products Online';
        $products = Product::where('featured', 0)
                          ->orderBy('products.id','desc')->take(20)->get();

        $featured_products = Product::where('products.featured',1)
                          ->orderBy('products.updated_at','desc')->take(12)->get();
        $previewEdit = 1;
        $categories = Category::orderBy('name')->get();
        $tags = Tags::orderBy('name')->get();
        $brands = Brand::latest()->get();

        if(Auth::guest()){
            $previewEdit = 0;
            return view('theme5.index', compact('title', 'previewEdit', 'categories','featured_products','products','tags','brands'));

        }
        if( Auth::user()->roles()->first()->role == 'Admin' || Auth::user()->roles()->first()->role == 'Supplier') {
        return view('theme5.previewEdit', compact('title', 'previewEdit', 'categories','featured_products', 'products','tags','brands'));
        }else{
            $previewEdit = 0;
            return view('theme5.index', compact('title', 'previewEdit', 'categories','featured_products','products','tags','brands'));
        }
    }


    public function listVendors() {
        $title = 'Vendors List';

        return view('theme5.list')->with(['title' => $title]);
    }

    public function login_new() {
        $title = 'Login Form';

        return view('theme5.login')->with(['title' => $title]);
    }

    public function register_new() {
        $title = 'Register Form';

        return view('theme5.register')->with(['title' => $title]);
    }

    public function reset_password() {
        $title = 'Reset Password';

        return view('theme5.reset_password')->with(['title' => $title]);
    }

    public function get_products_by_category($slug){

        $id_get = Category::where('slug', $slug)->first();
        if( !$id_get ){
            return redirect()->route('index');
        }
        $id = $id_get->id;

        if (request()->sort == 'low_high') {
            // $products = Category::find($id)->products()->orderBy('rate')->paginate(12);
            $pc = Category::select('id')->where('parentId', $id)->get()->pluck('id', 'id')->toArray();
            $list_ids = $pc;
            $list_ids[] = $id;

            $products = Product::notsuspended()->whereIn('products.categoryId', $list_ids)->orderBy('rate')->paginate(12);

        }elseif(request()->sort == 'high_low'){
            // $products = Category::find($id)->products()->orderBy('rate', 'desc')->paginate(12);
            $pc = Category::select('id')->where('parentId', $id)->get()->pluck('id', 'id')->toArray();
            $list_ids = $pc;
            $list_ids[] = $id;

            $products = Product::notsuspended()->whereIn('products.categoryId', $list_ids)->orderBy('rate','desc')->paginate(12);

        }elseif(request()->rating == 'low_high'){
            $products = Category::find($id)->products()->notsuspended()
                ->with(['ratings' => function ($query){
                            $query->orderBy('rating');
                        }])->paginate(12);
        }elseif(request()->rating == 'high_low'){
            $products = Category::find($id)->products()->notsuspended()
                ->with(['ratings' => function ($query){
                            $query->orderBy('rating', 'desc');
                        }])->paginate(12);
        }
        else{
            $pc = Category::select('id')->where('parentId', $id)->get()->pluck('id', 'id')->toArray();
            $list_ids = $pc;
            $list_ids[] = $id;

            $products = Product::notsuspended()->whereIn('products.categoryId', $list_ids)->orderBy('productName')->paginate(15);
        }
        $catname = Category::find($id);
        $parentcategories = Category::where('parentId', $id)->get()->take(10);
        $title = 'Category: ' . $catname->name;
        return view('theme5.products')->with([
                                                'products' => $products,
                                                'categories' => Category::all(),
                                                'catname' => $catname,
                                                'title' => $title,
                                                'cat' => $id_get,
                                                'parentcategories' => $parentcategories
                                            ]);

    }

    public function get_all_featured(){


        if (request()->sort == 'low_high') {
            $products = Product::where('featured', 1)->orderBy('rate')->paginate(9);
        }elseif(request()->sort == 'high_low'){
            $products = Product::where('featured', 1)->orderBy('rate', 'desc')->paginate(9);
        }elseif(request()->rating == 'low_high'){
            $products = Product::where('featured', 1)->with(['ratings' => function ($query){
                            $query->orderBy('rating');
                        }])->paginate(9);
        }elseif(request()->rating == 'high_low'){
            $products = Product::where('featured', 1)->with(['ratings' => function ($query){
                            $query->orderBy('rating', 'desc');
                        }])->paginate(9);
        }
        else{
            $products = Product::where('featured', 1)->orderBy('productName')->paginate(9);
        }

        $title = 'Featured Products';
        return view('theme5.products')->with([
                                                'products' => $products,
                                                'title' => $title
                                            ]);
    }

    public function get_all_products_more(){


        if (request()->sort == 'low_high') {
            $products = Product::where('featured', 0)->orderBy('rate')->paginate(9);
        }elseif(request()->sort == 'high_low'){
            $products = Product::where('featured', 0)->orderBy('rate', 'desc')->paginate(9);
        }elseif(request()->rating == 'low_high'){
            $products = Product::where('featured', 0)->with(['ratings' => function ($query){
                            $query->orderBy('rating');
                        }])->paginate(9);
        }elseif(request()->rating == 'high_low'){
            $products = Product::where('featured', 0)->with(['ratings' => function ($query){
                            $query->orderBy('rating', 'desc');
                        }])->paginate(9);
        }
        else{
            $products = Product::where('featured', 0)->orderBy('productName')->paginate(9);
        }

        $title = 'View All Products';
        return view('theme5.products')->with([
                                                'products' => $products,
                                                'title' => $title
                                            ]);
    }

    public function get_all_products_brands($id){


        if (request()->sort == 'low_high') {
            $products = Product::where('brand_id', $id)->orderBy('rate')->paginate(9);
        }elseif(request()->sort == 'high_low'){
            $products = Product::where('brand_id', $id)->orderBy('rate', 'desc')->paginate(9);
        }elseif(request()->rating == 'low_high'){
            $products = Product::where('brand_id', $id)->with(['ratings' => function ($query){
                            $query->orderBy('rating');
                        }])->paginate(9);
        }elseif(request()->rating == 'high_low'){
            $products = Product::where('brand_id', $id)->with(['ratings' => function ($query){
                            $query->orderBy('rating', 'desc');
                        }])->paginate(9);
        }
        else{
            $products = Product::where('brand_id', $id)->paginate(9);
        }

        $brandname = Brand::where('brandId', $id)->first();
        $title = 'Brand: ' . $brandname->brandName;
        return view('theme5.products')->with([
                                                'products' => $products,
                                                'title' => $title
                                            ]);
    }




    public function view_product( $slug ) {

        $product = Product::where('slug', $slug)->firstOrFail();
        if (empty($product)) {
            return redirect()->route('index');
        }
        $cat_id = $product->categoryId;
        $category = Category::find($cat_id);
        $ratings = $product->ratings()->select('rating')->get();
        $averageRating = collect($ratings)->avg('rating');

        $productsOfCategory = '';
        $productReviews = '';
        $productsOfCategory = Product::notsuspended()->orderBy('products.created_at', 'desc')->where('products.categoryId', $cat_id)->where('products.id', '!=', $product->id)->get()->take(8);
        $productReviews = $product->reviews()->orderBy('created_at')->get();

        $relatedproducts = Product::notsuspended()->where('categoryId', $cat_id)->where('products.id', '!=', $product->id)->inRandomOrder()->get()->take(4);


        // Check parent
        $parentId = $category->parentId;
        $parent = Category::find($parentId);
        if ($parent) {
            $parentSlug = $parent->slug;
        }else{
            $parentSlug = 'all';
        }

        // Check layout in terms of parent
        $layout = 'default';
        if( $parentSlug == 'fashion' )  {
            $layout = 'other';
        }

        $shop = Supplier::where('user_id', $product->merchantId)->first();
        if($shop){
            $shop_name = $shop->detail;
        }else{
            $shop_name = NULL;
        }

        return view('theme5.single')->with([
                                                'product'=> $product,
                                                'productsOfCategory' => $productsOfCategory,
                                                'productReviews' => $productReviews,
                                                'averageRating' => $averageRating,
                                                'category' => $category,
                                                'relatedproducts' => $relatedproducts,
                                                'parentSlug' => $parentSlug,
                                                'shop_name' => $shop_name,
                                                'parent' => $parent,
                                                'layout' => $layout
                                                ]);
    }

    public function view_product_id( $id ) {

        $product = Product::where('id', $id)->firstOrFail();
        if (empty($product)) {
            return redirect()->route('index');
        }
        $cat_id = $product->categoryId;
        $category = Category::find($cat_id);
        $ratings = $product->ratings()->select('rating')->get();
        $averageRating = collect($ratings)->avg('rating');

        $productsOfCategory = '';
        $productReviews = '';
        $productsOfCategory = Product::notsuspended()->latest()->where('categoryId', $cat_id)->where('id', '!=', $product->id)->get()->take(8);
        $productReviews = $product->reviews()->orderBy('created_at')->get();

        $relatedproducts = Product::notsuspended()->where('categoryId', $cat_id)->where('id', '!=', $product->id)->inRandomOrder()->get()->take(4);


        // Check parent
        $parentId = $category->parentId;
        $parent = Category::find($parentId);
        if ($parent) {
            $parentSlug = $parent->slug;
        }else{
            $parentSlug = 'all';
        }

        // Check layout in terms of parent
        $layout = 'default';
        if( $parentSlug == 'fashion' )  {
            $layout = 'other';
        }

        $shop = Supplier::where('user_id', $product->merchantId)->first();
        if($shop){
            $shop_name = $shop->detail;
        }else{
            $shop_name = NULL;
        }

        return view('theme5.single')->with([
                                        'product'=> $product,
                                        'productsOfCategory' => $productsOfCategory,
                                        'productReviews' => $productReviews,
                                        'averageRating' => $averageRating,
                                        'category' => $category,
                                        'relatedproducts' => $relatedproducts,
                                        'parentSlug' => $parentSlug,
                                        'shop_name' => $shop_name,
                                        'parent' => $parent,
                                        'layout' => $layout
                                        ]);
    }

    public function wishlist($userId)
    {
        $user = User::find($userId);
        $wishlist = $user->wishlists()->where('deleted', 0)->get()->pluck('productId')->toArray();

        $products = Product::wherein('products.id', $wishlist)->paginate(9);

        $title = 'Your Wish List';
        return view('theme5.wishlist', compact('products', 'title'));
    }

    public function user_orders($userId){
        $user = User::find($userId);
        $orders = Order::where('ordered_by', $userId)->paginate(20);

        // dd($orders);
        return view('theme5.wishlist', compact('products', 'title'));
    }

    public function search_product(Request $request) {

        $this->validateWith([
            'search' => 'required',
        ]);

        $products = Product::where('productName', 'like', '%'.$request->search.'%')->paginate(9);

        $title = 'Search results for "' . $request->search . '"';
        return view('theme5.wishlist', compact('products', 'title'));

    }

    public function filter_vendor_product(Request $request) {
        // dd($request);
        if($request->catId == 'all'){
            $vendor_id = Product::select('merchantId')->get();
        }else{
            $vendor_id = Product::select('merchantId')
                            ->where('categoryId', $request->catId)
                            ->join('suppliers.user_id', 'merchantId', '=', 'suppliers.user_id')
                            ->get();
            // foreach ($supp as $val) {
            //     $data[] = Supplier::where('user_id', '=', $val);
            // }
            // $supplier = Supplier::where('user_id', '=', $vendor_id);
        }

        return response()->json(['supplier' => $vendor_id, 'status' => 200]);
    }

    public function vendorStore($userId)
    {
        $supplier = Supplier::where('user_id', $userId)->first();
        $cat = Category::latest()->take(1)->first();
        $categories = Category::latest()->skip(1)->take(15)->get();
        // $wishlist = $user->wishlists()->where('deleted', 0)->get()->pluck('productId')->toArray();

        $products = Product::where('merchantId', $userId)->where('categoryId', $cat->id)->get();

        $title = 'Vendor';
        return view('theme5.store', compact('products', 'title','cat','categories','supplier'));
    }

    public function filter_cat_items(Request $request) {
        $cat_id = $request->catId;
        $store_id = $request->storeId;
        // dd($request);

        $products = Products::where('category', $cat_id)->where('merchantId', $store_id)->get();
        return view('theme5.layouts.showfilter', compact('products'));

        // $returnHTML = view('theme5.layouts.showfilter')->with('products', $products)->render();
        // return response()->json(array('success' => true, 'html'=>$returnHTML));

        // return response()->json(['supplier' => $vendor_id, 'status' => 200]);
    }

    public function contact() {
        return view('theme5.contact');
    }

    public function privacy_policy() {
        return view('theme5.privacypolicy');
    }

    public function cart_view() {
        $shipping = DB::table('shipping_type')->first();
        $rate = $shipping ? $shipping->rate : 0;
        return view('theme5.cart', compact('rate'));
    }

    public function checkout_view() {
        $shipping = DB::table('shipping_type')->first();
        $rate = $shipping ? $shipping->rate : 0;
        return view('theme5.checkout', compact('rate'));
    }

    public function about_us() {
        return view('theme5.aboutus');
    }

    public function privacy_policy_app() {
        return view('theme5.privacy_policy_app');
    }

    public function fetch_sub_category(Request $request){
        $catId = $request->cat_id;
        $actualparent = Category::find($catId);
        $parentslug = $actualparent->slug;
        $parent = Category::where('parentId', $catId)->get()->pluck('id')->toArray();
        $products = Product::notsuspended()->whereIn('categoryId', $parent)->orderBy('productName', 'ASC')->get();
        $filter = $products;
        // return $this->jsonResponse(['success' => true, 'html' => $html]);

        $html = view('theme5.layouts.filter_category')->with(compact('filter', 'parentslug'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function ajax_get_products(Request $request){
        $catId = $request->cat_id;
        $parent = Product::where('categoryId', $catId)->get();

        $filter = $parent;
        // return $this->jsonResponse(['success' => true, 'html' => $html]);

        $html = view('theme5.layouts.fetch_products')->with(compact('filter'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function merchant_signup() {
        $title = 'Merchant Signup';

        return view('theme5.merchantSignup')->with(['title' => $title]);
    }

    public function front_user_orders($id) {

        $title = "Your Pending Orders:";

        $user = User::findOrFail($id);
        $orders = Order::join('payment_details', 'payment_details.payment_id', '=', 'orders.payment_details_id')
          ->where('payment_details.status', '0')
          ->where('orders.order_status', '1')->orwhere('orders.order_status', '2')
          ->where('orders.ordered_by', $id)
          ->orderBy('order_date', 'desc')
          ->get()->take(4);

        return view('theme5.orderstatus', compact('title', 'user', 'orders'));

    }

    public function delivery_assigned_list() {
        $user = Auth::user();

        $orders = DB::table('delivery_assigned')->where('delivery_assigned.user_id', $user->id)
        ->join('orders', 'orders.id', '=', 'delivery_assigned.order_id')
        ->get();
        $pg = 1;
        return view('admin.orders_assigned', compact('orders', 'user', 'pg'));
    }

    public function all_orders_deliveryadmin() {

      $orders = Order::latest()
        ->join('payment_details', 'payment_details.payment_id', '=', 'orders.payment_details_id')
        ->where('payment_details.status', '0')
        ->where('orders.order_status', '1')->orwhere('orders.order_status', '2')
        ->orderBy('order_date')
        ->get();
      $user = Auth::user();
      $pg = 2;
      return view('admin.orders_assigned', compact('orders', 'user', 'pg'));

    }

    public function cancel_user_order(Request $request) {

      $this->validateWith([
        'orderStatus' => 'required',
        'orderId' => 'required'
      ]);

      Order::where('id', $request->orderId)->update([
        'order_status' => 0
      ]);

      Session::flash('success', 'Succesfully canceled your order. Shop with us again!');

      return redirect()->back();

    }

    public function front_user_shipping_details($id) {

        $uid = Auth::id();
        $shippingdetails = DB::table('shipping_details')->where('customer_id', $uid)->orderBy('shipping_details_id', 'desc')->take(3)->get();
        return view('theme5.shippingdetails', compact('uid', 'shippingdetails'));

    }

    public function front_edit_user_shipping_details($id) {

        $uid = Auth::id();
        $shippingdetails = DB::table('shipping_details')->where('customer_id', $uid)->orderBy('shipping_details_id', 'desc')->take(3)->get();
        $toedit = 1;
        $details = DB::table('shipping_details')->where('customer_id', $uid)->where('shipping_details_id', $id)->first();
        return view('theme5.shippingdetails', compact('uid', 'shippingdetails', 'toedit', 'details'));

    }

    public function update_shipping_detail(Request $request) {

        $this->validateWith([
            'fullName' => 'required',
            'phoneNo' => 'required',
            'shippingAddress' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);

        if( $request->shippingId ) {
            ShippingDetail::where('customer_id', Auth::id())->update(['active' => 0]);
            $detail = ShippingDetail::find($request->shippingId);
        }else{
            $detail = new ShippingDetail;
        }

        $detail->client_name = $request->fullName;
        $detail->phone = $request->phoneNo;
        $detail->address = $request->shippingAddress;
        $detail->state = $request->state;
        $detail->near_by_places = $request->alias;
        $detail->city = $request->city;
        $detail->email = $request->email;
        $detail->alternatePhone = $request->phoneNumber;
        $detail->customer_id = Auth::id();
        if ( $request->makeDefault ) {
          $detail->active= 1;
        }

        $detail->save();

        Session::flash('success', 'Sucessfully updated.');

        return redirect()->route('user.shipping.details', Auth::id());

    }

    public function delivery_signup() {
      return view('theme5.deliveryregister');
    }

    public function delivery_register(Request $request) {


      $this->validateWith([
          'fullName' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'username' => 'required|string|max:255|unique:users',
          'password' => 'required|string|min:6|confirmed',
          'vehicleNumber' => 'required',
          'streetAddress' => 'required',
          'city' => 'required',
          'phoneNumber' => 'required',
          'licenceCopy' => 'required|file'
        ]);

        $token = Str::random(60);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'suspend' => 1,
            'verifyToken' => $token,
        ]);

        $uid = $user->id;

        DB::table('role_user')->insert([
            'user_id' => $uid,
            'role_id' => 4,
        ]);

        $data = new Delivery;
        $data->user_id = $uid;
        $data->supplier_id = 2;

        $data->save();

        $merchant = new Profile;

        $merchant->user_id = $uid;
        $merchant->fName = $request->fullName;
        $merchant->lName = 'fordelivery';
        $merchant->street = $request->streetAddress;
        $merchant->city = $request->city;
        $merchant->phone = $request->phoneNumber;
        $merchant->licenseNumber = $request->vehicleNumber;

        $license = $request->file('licenceCopy');
        $ffname = 'license-' . str_slug( $request->fullName ) . '-' . str_random(8) . '.' . $license->getClientOriginalExtension();

        $license->move('uploads/deliveryusers', $ffname);

        $merchant->licenseCard = $ffname;

        $merchant->save();

        $to = $request->email;
        $verificationlink = route('verify.email', [$uid, $token]);
        $data = [];
        $data['emailName'] = $to;
        $data['username'] = $request->username;
        $data['verificationlink'] = $verificationlink;
        $data['fromEmail'] = "info@chaiyo.shop";
        $data['fromName'] = "Chaiyo Shop Nepal";
        $data['emailSubject'] = "Verify Delivery UserAccount | Chaiyo.Shop";

        $data = (object) $data;

        try {
          \Mail::to($to)->send( new VerifyEmail($data) );
        } catch (Exception $e) {
            Session::flash('info', 'Invalid Email. Please contact us for verification.');
            return redirect()->back();
        }

        Session::flash('info', 'A verification email has been sent to your address for security reasons. Please follow further instructions. Thanks!');

        return redirect()->back();

    }

}
