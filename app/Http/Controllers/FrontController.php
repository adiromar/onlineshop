<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Profile;
use App\Category;
use App\Setting;
use App\Wishlist;
use App\Tags;
use App\Reviews;
use DB;
use Auth;
use Session;
use Validator;
use Cart;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;

class FrontController extends Controller
{
    public function index() {
        $title = 'Aryal Enterprise';

        $products = Product::where('featured', 0)
            ->orderBy('products.id','desc')->take(3)->get();

        $featured_products = Product::where('products.featured',1)
            ->orderBy('products.updated_at','desc')->take(12)->get();

        $categories = Category::orderBy('name')->get();
        $tags = Tags::orderBy('name')->get();
        return view('theme11.index', compact('title', 'categories','featured_products','products','tags'));
  }

  public function previewEdit() {
    $title = 'Aryal Marketing';
    $products = Product::where('featured', 0)
                          ->orderBy('products.id','desc')->take(20)->get();

        $featured_products = Product::where('products.featured',1)
                          ->orderBy('products.updated_at','desc')->take(12)->get();
        $previewEdit = 1;
        $categories = Category::orderBy('name')->get();
        $tags = Tags::orderBy('name')->get();

        if(Auth::guest()){
            $previewEdit = 0;
            return view('theme11.index', compact('title', 'previewEdit', 'categories','featured_products','products','tags'));

        }
      if( Auth::user() ) {
          return view('theme11.previewEdit', compact('title', 'previewEdit', 'categories','featured_products', 'products','tags'));
          }else{
              $previewEdit = 0;
              return view('theme11.index', compact('title', 'previewEdit', 'categories','featured_products','products','tags'));
          }
    }



    public function get_more_products_new(){

        $products = Product::notsuspended()
                            ->orderBy('products.id','desc')
                            ->skip(6)->take(33)->get();
        $title = "More Products";

        return view('theme1.products-more',compact('products', 'title'));
    }

    public function get_products_by_category_new($slug){

        $id_get = Category::where('slug', $slug)->first();
        if( !$id_get ){
            return redirect()->route('index');
        }
        $id = $id_get->id;

        if (request()->sort == 'low_high') {
            $products = Category::find($id)->products()->orderBy('rate')->paginate(9);
        }elseif(request()->sort == 'high_low'){
            $products = Category::find($id)->products()->orderBy('rate', 'desc')->paginate(9);
        }elseif(request()->rating == 'low_high'){
            $products = Category::find($id)->products()
                ->with(['ratings' => function ($query){
                            $query->orderBy('rating');
                        }])->paginate(9);
        }elseif(request()->rating == 'high_low'){
            $products = Category::find($id)->products()
                ->with(['ratings' => function ($query){
                            $query->orderBy('rating', 'desc');
                        }])->paginate(9);
        }
        else{
            $products = Category::find($id)->products()->orderBy('productName')->paginate(9);
        }
        $catname = Category::find($id);
        $title = 'Category: ' . $catname->name;
        return view('theme1.products')->with([
                                                'products' => $products,
                                                'categories' => Category::all(),
                                                'catname' => $catname,
                                                'title' => $title
                                            ]);


    }

    public function view_product_new($slug){

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
        $productsOfCategory = Product::latest()->where('categoryId', $cat_id)->where('id', '!=', $product->id)->get()->take(4);
        $productReviews = $product->reviews()->orderBy('created_at')->get();

        return view('theme1.product-single')->with([
                                                'product'=> $product,
                                                'productsOfCategory' => $productsOfCategory,
                                                'productReviews' => $productReviews,
                                                'averageRating' => $averageRating,
                                                'category' => $category
                                                ]);
    }

    public function wishlist($userId)
    {
        $user = User::find($userId);
        $wishlists = $user->wishlists()->where('deleted', 0)->get();
        $title = 'Your Wish List';
        return view('theme1.wishlist', compact('user', 'wishlists', 'title'));
    }

    public function wishlist_add($productId)
    {
        $userId = Auth::id();

        // Check if already added
        $check = Wishlist::where('userId', $userId)->where('productId', $productId)->first();

        if ( $check ) {

            if ( $check->deleted == 0 ) {
                $check->deleted = 1;
                Session::flash('info', 'Removed from your Wish List.');
            }else{
                $check->deleted = 0;
                Session::flash('info', 'Added to Wish List.');
            }


            $check->save();



            return redirect()->back();
        }

        $wishlist = new Wishlist;

        $wishlist->userId = $userId;
        $wishlist->productId = $productId;

        $wishlist->save();

        Session::flash('success', 'Added to Wish List');

        return redirect()->back();

    }

    public function products_by_tag($tagslug)
    {
        $tag = Tags::where('slug', $tagslug)->first();

        dd($tag);
    }

    public function login() {
        $title = 'Login Form';

        return view('theme11.login')->with(['title' => $title]);
    }

    public function cart_view()
    {
        return view('theme1.cart');
    }

    public function checkout_view()
    {
        return view('theme1.checkout');
    }

    public function privacy_policy()
    {
        return view('theme1.policy');
    }

    public function get_featured_products(){

        $products = Product::notsuspended()
                            ->where('products.featured',1)
                            ->orderBy('products.updated_at','desc')
                            ->offset(6)->limit(24)->get();

        return view('pages.products.featured',compact('products', $products));
    }

    public function get_more_products(){

        $products = Product::notsuspended()
                            ->orderBy('products.id','desc')
                            ->skip(16)->take(100)->get();

        return view('pages.products.more',compact('products', $products));
    }

    public function get_all_suppliers(){

      return view('pages.suppliers.index')->with('users', User::where('suspend',0)->orderBy('id','desc')->get());
    }

    public function view_supplier($id,$name){

    	$user = User::find($id);

        if ($user) {
            $videos = DB::table('videos')->where('user_id',$id)->orderBy('created_at','desc')->get();

            if ($user->profile) {
                return view('pages.suppliers.profile')->with('user',$user)->with('videos', $videos);
            }else{
                return redirect()->route('suppliers');
            }
        }else{
          session()->flash('info', 'There is no such supplier.');
            return redirect()->back();
        }

    }

    public function view_product($slug){

        $product = Product::where('slug', $slug)->firstOrFail();
        if (empty($product)) {
            return redirect()->route('index');
        }
        $cat_id = $product->categoryId;

        $ratings = $product->ratings()->select('rating')->get();
        $averageRating = collect($ratings)->avg('rating');

        $productsOfCategory = '';
        $productReviews = '';
        $productsOfCategory = Product::latest()->where('categoryId', $cat_id)->where('id', '!=', $product->id)->get()->take(4);
        $productReviews = $product->reviews()->orderBy('created_at')->get();

    	return view('pages.products.single')->with([
                                                'product'=> $product,
                                                'productsOfCategory' => $productsOfCategory,
                                                'productReviews' => $productReviews,
                                                'averageRating' => $averageRating
                                                ]);
    }

    public function get_products_by_category($slug){

        $id_get = Category::where('slug', $slug)->first();
        if(empty($id_get)){
            return redirect()->route('index');
        }
        $id = $id_get->id;

        if (request()->sort == 'low_high') {
            $products = Category::find($id)->products()->orderBy('rate')->paginate(9);
        }elseif(request()->sort == 'high_low'){
            $products = Category::find($id)->products()->orderBy('rate', 'desc')->paginate(9);
        }elseif(request()->rating == 'low_high'){
            $products = Category::find($id)->products()
                ->with(['ratings' => function ($query){
                            $query->orderBy('rating');
                        }])->paginate(9);
        }elseif(request()->rating == 'high_low'){
            $products = Category::find($id)->products()
                ->with(['ratings' => function ($query){
                            $query->orderBy('rating', 'desc');
                        }])->paginate(9);
        }
        else{
            $products = Category::find($id)->products()->orderBy('productName')->paginate(9);
        }
        $catname = Category::find($id);

        return view('pages.products.category-products')->with([
                                                            'products' => $products,
                                                            'categories' => Category::all(),
                                                            'catname' => $catname
                                                        ]);


    }

    public function search_product(Request $request){

        //Manually making a validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash('info', 'You must provide a product title.');
            return redirect()->back();
        }

        $string = $request->name;
        $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);
        $results = Product::select('products.id','products.title','products.slug','products.user_id','products.image', 'products.price','profiles.address')
                ->where(function ($q) use ($searchValues) {
                    foreach ($searchValues as $value) {
                        $value = strtolower($value);
                        $q->orWhere('products.title', 'like', "%{$value}%")->orWhere('products.keywords','like',"%{$value}%");
                    }
                })->join('profiles', 'products.user_id', '=', 'profiles.user_id')
            ->where('profiles.address', 'like', '%'. strtolower($request->location) .'%')->get();

        $request->flashOnly('name', 'location');
        return view('pages.searchresult')->with('results', $results)
                                        ->with('name', $request->name)
                                        ->with('location', $request->location);
    }

    public function get_products_by_location(Request $request){

      $catid = $request->cat_id;
      $location = $request->location;

      $catname = Category::find($catid);
      $products = $catname->products();

      $q = $products->join('profiles', 'products.user_id', '=', 'profiles.user_id')
      ->where('profiles.address', 'like', '%'. $request->location .'%')->paginate(9);

      return view('pages.products.category-products')->with([
                                                          'products' => $q,
                                                          'categories' => Category::all(),
                                                          'catname' => $catname
                                                      ]);

    }

    public function set_session_product_id(){

        session([ 'product_id' => request()->product_id, 'product_slug' => request()->slug ]);
        return response(session()->all());
    }

    public function boost_order_store(Request $request){
        date_default_timezone_set('Asia/Kathmandu');
        DB::table('boost_orders')->insert([
                                            'name' => $request->name,
                                            'phone' => $request->mobile,
                                            'address' => $request->delivery_address,
                                            'message' => $request->message,
                                            'created_at' => date('Y-m-d G:i:s'),
                                            'updated_at' => date('Y-m-d G:i:s')
                                        ]);

        session()->flash('success', 'Your order has been succesfully delivered.');
        return redirect()->back();
    }

    public function add_review(Request $request){

        $this->validateWith([
                'review' => 'required',
                'email' => 'required',
        ]);

        $r = new Reviews;

        $r->user_id = $request->supplier_id;
        $r->review = $request->review;
        $r->name = $request->fullname;
        $r->email = $request->email;

        $r->save();
        session()->flash('success', 'Thanks for contacting us. We will get back to you shortly.');
        return redirect()->back();

    }

    public function insert_product_review(Request $request){

        $this->validateWith([
                'reviewTitle' => 'required',
                'user_id' => 'required',
                'product_id' => 'required',
                'rating' => 'required'
        ]);

        if ($request->reviewDesc) {

            $review = new Reviews;

            $review->reviewTitle = $request->reviewTitle;
            $review->email = $request->email;
            $review->reviewDesc = $request->reviewDesc;
            $review->rating = $request->rating;
            $review->userId = $request->user_id;
            $review->productId = $request->product_id;
            $review->productName = $request->productName;

            $review->save();

            $product = Product::where('id', $request->product_id)->first();

            $nosreviews = $product->nosReview;

            $product->nosReview = $nosreviews + 1;

            $product->save();
        }

        if ($request->rating) {
            DB::table('ratings')->insert([
                                            'user_id' => $request->user_id,
                                            'product_id' => $request->product_id,
                                            'rating' => $request->rating,
                                        ]);
        }

        session()->flash('success', 'Thanks for adding your valuable input.');

        return redirect()->back();

    }

    public function ajax_cart_update(Request $request) {


        $duplicates = Cart::search(function ($cartItem, $rowId) use($request) {
            return $cartItem->id === $request->productId;
        });

        if ( $duplicates->isNotEmpty() ) {
            return response()->json(['status' => 201]);
        }else{
            Cart::add($request->productId, $request->productName, 1, $request->rate)
                ->associate('App\Product');
            return response()->json(['status' => 200]);
        }

    }

    public function ajax_wishlist_update(Request $request) {

        $productid = $request->productId;

        if ( Auth::user() ) {

            $userid = Auth::id();

            $check = Wishlist::where('userId', $userid)->where('productId', $productid)->first();
            $message = '';
            if ( $check ) {

            if ( $check->deleted == 0 ) {
                $check->deleted = 1;

                $message = 'Removed from your Wish List.';

                $check->save();

                return response()->json(['message' => $message, 'status' => 200]);

            }elseif( $check->deleted == 1 ) {
                $check->deleted = 0;

                $message = 'Added to Wish List.';

                $check->save();

                return response()->json(['message' => $message, 'status' => 200]);

            }

            }else{

                $wish = new Wishlist;

                $wish->userId = $userid;
                $wish->productId = $productid;

                $wish->save();

                return response()->json(['message' => 'Added to Wish List.', 'status' => 200]);

            }

        }else{

            return response()->json(['status' => 201]);

        }

    }

    public function register_user(Request $request) {

      $this->validateWith([
        'firstName' => 'required|string|alpha|max:255',
        'lastName' => 'required|string|alpha|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'username' => 'required|string|alpha_dash|max:255|unique:users',
        'password' => 'required|string|min:6|regex:/^(?=(.*[a-zA-Z].*){2,})(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{4,15}$/|confirmed',
        'terms' => 'required',
        'streetAddress' => 'required',
        'city' => 'required',
        // 'phoneNumber' => 'required|integer|min:10|max:10',
        'phoneNumber' => 'required|integer|digits:10'
      ]);

      // die;

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
          'role_id' => 3,
      ]);

      $profile = new Profile;

      $profile->user_id = $uid;
      $profile->fName = $request->firstName;
      $profile->mName = $request->middleName;
      $profile->lName = $request->lastName;
      $profile->street = $request->streetAddress;
      $profile->city = $request->city;
      $profile->phone = $request->phoneNumber;

      $profile->save();

      // Sending email
      $to = $request->email;
      $verificationlink = $verificationlink = url('user/verification') . "/" . $uid . "/" . $token;
      $data = [];
      $data['emailName'] = $to;
      $data['username'] = $request->username;
      $data['verificationlink'] = $verificationlink;
      $data['fromEmail'] = "info@chaiyo.shop";
      $data['fromName'] = "Chaiyo Shop Nepal";
      $data['emailSubject'] = "Verify Account | Chaiyo.Shop";

      $data = (object) $data;

      try {
        \Mail::to($to)->send( new VerifyEmail($data) );
      } catch (Exception $e) {
          Session::flash('info', 'Invalid Email. Please contact us for verification.');
          return redirect()->back();
      }

      Session::flash('info', 'An email has been sent to your address. Please follow further instructions. Thanks!');

      return redirect('/');

    }

    public function verify_user($id, $token) {

      $user = User::where('id', $id)->where('verifyToken', $token)->firstOrFail();

      $user->verifyToken = null;
      $user->suspend = 0;
      $user->save();

      Session::flash('success', 'You have been Verified succesfully. Thanks for joining us!');

      return redirect('/');

    }

}
