<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Profile;
use App\User;
use App\Product;
use App\Sliders;
use App\Productimage;
use App\Reviews;
use App\Wishlist;
use App\Tags;
use App\Order;
use App\OrderNew;
use App\OrderDetail;
use App\OrderDetailNew;
// use App\Khalti;
use Image;
use DB;


use Validator;

class ApiController extends Controller
{
    /*
        @GET("/api/v1/products/sales")
        Call<Response> getSalesProduct();
    */
    public function getSalesProduct(Request $request) {
        $last_seen = $request->last_seen;
        $pageSize = $request->pageSize;
        $action = $request->action;

        if($last_seen == 0){
            $products = Product::select('id')->where('discountPercent', '>', 0)->where('discountPercent', '!=', NULL)->latest()->get()->take($pageSize);
        }else{
            if($action == "first"){
                $products = Product::select('id')->where('discountPercent', '>', 0)->where('discountPercent', '!=', NULL)->where('id', '<', $last_seen)->latest()->get()->take($pageSize);
            }elseif($action == "next"){
                $products = Product::select('id')->where('discountPercent', '>', 0)->where('discountPercent', '!=', NULL)->where('id', '<', $last_seen)->latest()->get()->take($pageSize);
            }else{
                $products = Product::select('id')->where('discountPercent', '>', 0)->where('discountPercent', '!=', NULL)->where('id', '<', $last_seen)->latest()->get()->take($pageSize);
            }
        }
        

        if ( count($products) ) {
   
            foreach ($products as $product) {
                $data[] = $this->productDTO($product->id);
            }

            return $this->jsonResponse($data, 200);    
        }

        return $this->jsonResponse($products, 404, 'No data');
    }

public function getMostBought(Request $request) {
        $last_seen = $request->last_seen;
        $pageSize = $request->pageSize;
        $action = $request->action;

        // $products = Product::where('totalSoldQuantity', '>',0)->orderBy('totalSoldQuantity', 'DESC')->get()->take(6);
        
        if($last_seen == 0){
            $products = DB::table('order_details')->select('product_id')->groupBy('product_id')->orderBy('product_id', 'desc')->get()->take($pageSize);
        }else{
            if($action == "first"){
                // nothing
                $products = DB::table('order_details')->select('product_id')->where('product_id', '<', $last_seen)->groupBy('product_id')->orderBy('product_id', 'desc')->get()->take($pageSize);
            }elseif($action == "next"){
                $products = DB::table('order_details')->select('product_id')->where('product_id', '<', $last_seen)->groupBy('product_id')->orderBy('product_id', 'desc')->get()->take($pageSize);
            }else{
                $products = DB::table('order_details')->select('product_id')->where('product_id', '<', $last_seen)->groupBy('product_id')->orderBy('product_id', 'desc')->get()->take($pageSize);
            }
            
        }
        
        if ( count($products) ) {
   
            foreach ($products as $product) {
                $data[] = $this->productDTO($product->product_id);
            }

            return $this->jsonResponse($data, 200);    
        }

        return $this->jsonResponse($products, 404, 'No data.');
    }

    // public function getMostBought() {

    //     $products = Product::orderBy('totalSoldQuantity', 'DESC')->get()->take(6);

    //     if ( count($products) ) {
   
    //         foreach ($products as $product) {
    //             $data[] = $this->productDTO($product->id);
    //         }

    //         return $this->jsonResponse($data, 200);    
    //     }

    //     return $this->jsonResponse($products, 404, 'No data');
    // }

    /*
        @POST("/api/v1/users/register")
        Call<Response> registerUser(@Body UserDTO userDTO);
    */
    public function register(Request $request) {

        $username = $request->username;
        $email = $request->email;

        if ( User::where('username', $username)->count() > 0 ) {
            
            return response()->json(['message' => 'Username already taken.']);

        }elseif ( User::where('email', $email)->count() > 0 ) {
            
            return response()->json(['message' => 'Email already taken.']);

        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => str_random(60),
        ]);

        $uid = $user->id;

        $profile = new Profile;

        $profile->user_id = $uid;
        $profile->fName = $request->fName;
        $profile->mName = $request->mName;
        $profile->lName = $request->lName;
        $profile->street = $request->street;
        $profile->city = $request->city;
        $profile->phone = $request->phone;

        $profile->save();

        if ( $request->roleId == 0 ) {

            DB::table('role_user')->insert([
                'user_id' => $uid,
                'role_id' => 3,
            ]);
            
        }else{

            DB::table('role_user')->insert([
                'user_id' => $uid,
                'role_id' => 2,
            ]);

        }

        $data = $this->userDTO($uid);

        return $this->jsonResponse($data, 200);

    }

    /*
        @GET("api/v1/users/checkDuplicateEmail")
        Call<Response> checkDuplicateEmail(@Query("email") String email);
    */
    public function checkDuplicateEmail() {
        $check = User::where('email', request()->email)->count();
        if ( $check > 0 ) {
            $log1 = 'True';
            $log = $log1 === 'True'? true: false;
            return $this->jsonResponse($log, 200, 'Email Already Exists In Database!');
            // return response()->json(true);
        }else{
            $log11 = 'False';
            $logg = $log11 === 'False'? false: true;
            return $this->jsonResponse($logg, 200, 'Email not found in database. You can use this email.');
        }
    }

    /*
        @GET("api/v1/users/checkUserName")
        Call<Response> checkUserName(@Query("username") String username);
    */
   public function checkUserName() {

        // if ( User::where('username', request()->username)->count() > 0 ) {
        //     return response()->json(true);
        // }else{
        //     return response()->json(false);
        // }

        $check = User::where('username', request()->username)->count();
        if ( $check > 0 ) {
            $log1 = 'True';
            $log = $log1 === 'True'? true: false;
            return $this->jsonResponse($log, 200, 'Username Already Exists In Database!');
            // return response()->json(true);
        }else{
            $log11 = 'False';
            $logg = $log11 === 'False'? false: true;
            return $this->jsonResponse($logg, 200, 'Username not found in database. You can use this Username.');
        }


   }

    /*
        @GET("/api/v1/category")
        Call<Response> getAllCategories();
    */
    public function getAllCategories() {

        $categories = Category::select('id')->latest()->where('parentId', 0)->get();
        
        $data = [];
        if ( count($categories) ) {
            $i = 0;
            foreach ($categories as $category) {
                $data[] = $this->categoryDTO($category->id);
            
                // Get childCategories
                $children = Category::select('id')->where('parentId', $category->id)->get();
                $childrens = [];
                if ( count($children) ) {
                    $count = 0;
                    foreach ($children as $child) {
                        $childrens[] = $this->categoryDTO($child->id);
                        $childrens[$count]['childCategories'] = [];

                        $count++;    
                    }
                    $data[$i]['childCategories'] = $childrens;
                }else{
                    $data[$i]['childCategories'] = [];
                }

                $i++;
                
            }
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No such data found.');

    }

    public function getAllParentCategories(){
        $parentc = Category::where('parentId', '>', '0')->get()->pluck('parentId', 'parentId')->toArray();
        $parent = Category::wherein('id', $parentc)->get();

        if( count($parent) ){
            foreach ($parent as $pp) {
                $data[] = $this->categoryDTO($pp->id);
            }
            return $this->jsonResponse($data, 200, 'Success');
        }
        return $this->jsonResponse([], 200, 'No Parent Category');
    }
    /*
        @GET("/api/v1/category/featured")
        Call<Response> getFeaturedCategories();
    */
    public function getFeaturedCategories() {

        $categories = Category::select('id')->where('featured', '1')->inRandomOrder()->get()->take(6);

        $data = [];
        if ( count($categories) ) {
            $i = 0;
            foreach ($categories as $category) {
                $data[] = $this->categoryDTO($category->id);
            
                // Get childCategories
                $children = Category::select('id')->where('parentId', $category->id)->get();
                $childrens = [];
                if ( count($children) ) {
                    $count = 0;
                    foreach ($children as $child) {
                        $childrens[] = $this->categoryDTO($child->id);
                        $childrens[$count]['childCategories'] = [];

                        $count++;    
                    }
                    $data[$i]['childCategories'] = $childrens;
                }else{
                    $data[$i]['childCategories'] = [];
                }

                $i++;
                
            }
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No such data found.');

    }

    /*
        @GET("/api/v1/category/offered")
        Call<Response> getCategoryOffered();
    */
    public function getCategoryOffered()
    {
        $categories = Category::select('id')->where('offered', 1)->inRandomOrder()->get()->take(6);

        $data = [];
        if ( count($categories) ) {
            $i = 0;
            foreach ($categories as $category) {
                $data[] = $this->categoryDTO($category->id);
            
                // Get childCategories
                $children = Category::select('id')->where('parentId', $category->id)->get();
                $childrens = [];
                if ( count($children) ) {
                    $count = 0;
                    foreach ($children as $child) {
                        $childrens[] = $this->categoryDTO($child->id);
                        $childrens[$count]['childCategories'] = [];

                        $count++;    
                    }
                    $data[$i]['childCategories'] = $childrens;
                }else{
                    $data[$i]['childCategories'] = [];
                }

                $i++;
                
            }
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No such data found.');
    }

    /*
        @GET("/api/v1/category/parent/{parentId}")
        Call<Response> getCategoryByParentId(@Path("parentId") Integer parentId);
   */
    public function getCategoryByParentId($parentId) {

        $categories = Category::where('parentId', $parentId)->get();

        $data = [];
        if ( count($categories) ) {

            $i = 0;
            foreach ($categories as $category) {
                $data[] = $this->categoryDTO($category->id);

                // Get childCategories
                $children = Category::select('id')->where('parentId', $category->id)->get();
                $childrens = [];
                if ( count($children) ) {
                    $count = 0;
                    foreach ($children as $child) {
                        $childrens[] = $this->categoryDTO($child->id);
                        $childrens[$count]['childCategories'] = [];

                        $count++;    
                    }
                    $data[$i]['childCategories'] = $childrens;
                }else{
                    $data[$i]['childCategories'] = [];
                }

                $i++;
            }

            return $this->jsonResponse($data, 200);
        }
        
        return $this->jsonResponse($data, 404, 'No data.');

    }

    /*
        @GET("/api/v1/slider")
        Call<Response> getAllActiveSlider();
    */
   
    public function getAllActiveSlider() {

        $sliders = Sliders::select('sliderId', 'textMain', 'textSecondary', 'sliderImage', 'categoryId', 'categoryName', 'showSlider')->where('showSlider', 1)->latest()->get();

        if ( count($sliders) ) {
        
            foreach ($sliders as $slider) {
                $slider->sliderImage = url('/') . '/uploads/sliders/resized/' . $slider->sliderImage;
                $slider->showSlider = $slider->showSlider ? true : false;
            }
        
            return $this->jsonResponse($sliders, 200);
        }

        return $this->jsonResponse([], 404, 'No data');

    }

    /*
        @GET("/api/v1/slider")
        Call<Response> getAllActiveSlider();
    */
   
    public function getAllActiveOffers() {

        $offers = DB::table('offers')->latest()->where('status', 1)->get();

        if ( count($offers) ) {
        
            foreach ($offers as $offer) {
                $offer->featuredImage = url('/') . '/uploads/offers/resized/' . $offer->featuredImage;
                $offer->status = $offer->status ? true : false;
            }
        
            return $this->jsonResponse($offers, 200);
        }

        return $this->jsonResponse([], 404, 'No data');

    }
    
    /*
        @GET("/api/v1/products/featured")
        Call<Response> getFeaturedProducts();
    */
    public function getFeaturedProducts() {


        // $products = Product::where('featured', '1')->select('id')->inRandomOrder()->get()->take(12);
        $products = Product::select('id')->latest()->get()->take(12);
        
        $data = []; 
        if ( count($products) ) {
            foreach ($products as $product) {
               $data[] = $this->productDTO($product->id);
            }
            
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No data.');

    }

    /*
        @GET("/api/v1/products/category/{categoryId}")
        Call<Response> getProductsByCategoryId(@Path("categoryId") Integer categoryId,
                                               @Query("last_seen") Integer lastSeenId,
                                               @Query("pageSize") Integer size,
                                               @Query("action") String action);
    */
    public function getProductsByCategoryId($id) {

        $cat = Category::find($id);

        $data = [];

        if ( $cat ) {
            
            $products = $cat->products()->select('id')->latest()->get();

            if ( count($products) ) {
            
                foreach ($products as $product) {
                    $data[] = $this->productDTO($product->id);
                }

                return $this->jsonResponse($data, 200);

            }else{

                return $this->jsonResponse($data, 404, 'No data.');

            }

        }else{
            
            return $this->jsonResponse([], 404, 'No such category.');

        }

    }

    /*
        @GET("/api/v1/products/parentCategory/{categoryId}")
        Call<Response> getProductsByParentCategoryId(@Path("categoryId") Integer categoryId,
                                                     @Query("last_seen") Integer lastSeenId,
                                                     @Query("pageSize") Integer size,
                                                     @Query("action") String action);
    */
    public function getProductsByParentCategoryId($categoryId, Request $request) {
        $last_seen = $request->last_seen;
        $pageSize = $request->pageSize;
        $action = $request->action;

        $cat = Category::find($categoryId);

        $data = [];

        if ( $cat ) {
            if($last_seen == 0){
                $products = $cat->products()->select('id')->latest()->get()->take($pageSize);
            }else{
                if($action == 'first'){
                    $products = $cat->products()->select('id')->latest()->where('id', '<', $last_seen)->get()->take($pageSize);
                }elseif($action == 'next'){
                    $products = $cat->products()->select('id')->latest()->where('id', '<', $last_seen)->get()->take($pageSize);
                }else{
                    $products = $cat->products()->select('id')->latest()->where('id', '<', $last_seen)->get()->take($pageSize);
                }
                
            }
            

            if ( count($products) ) {
                
                foreach ($products as $product) {
                    $data[] = $this->productDTO($product->id);
                }
                // $data['last_seen'] = $product->id;
                return $this->jsonResponse($data, 200);

            }else{

                return $this->jsonResponse($data, 404, 'No data.');

            }

        }else{
            
            return $this->jsonResponse([], 404, 'No such category.');

        }

    }

    /*
        @GET("/api/v1/products/{productId}")
        Call<Response> getProductById(@Path("productId") Integer productId);
    */
   public function getProductById($productId) {

        $product = Product::find($productId);
        $data = [];
        if ( $product ) {
            
            $data = $this->productDTO($productId);

            $relatedProducts = Product::select('id')->latest()->where('categoryId', $product->categoryId)->where('id', '!=', $product->id)->get()->take(4);
            if ( count( $relatedProducts ) ) {
                
                foreach ($relatedProducts as $rid) {
                    $data['relatedProducts'][] = $rid->id;
                    $data['relatedProductDtos'][] = $this->productDTO($rid->id);
                }

            }else{
                $data['relatedProducts'] = [];
                $data['relatedProductDtos'] = [];
            }

            return $this->jsonResponse($data, 200);

        }
        
        return $this->jsonResponse($data, 404, 'No data');

   }

    /*
        @GET("/api/v1/review/reviewProduct/{productId}")
        Call<Response> getReviewByProductId(@Path("productId") Integer productId,
                                             @Query("last_seen") Integer lastSeenId,
                                             @Query("pageSize") Integer size,
                                             @Query("action") String action);
    */
    public function getReviewByProductId($productId)
    {
        $product = Product::find($productId);

        $data = [];
        if ( $product ) {
            
            if ( count($product->reviews) ) {
                foreach ($product->reviews()->select('id')->latest()->get() as $review) {
                    $data[] = $this->reviewsDto($review->id);
                }
            }
            // return $this->jsonResponse($data, 404, 'No data.');
        }
        if($data){
            return $this->jsonResponse($data, 200, 'Success');
        }else{
            return $this->jsonResponse($data, 200, 'No data');
        }

        

    }

    /*
        @GET("/api/v1/review/{userId}/user")
        Call<Response> getAllReviews(@Header("Authorization") String token,
                                     @Path("userId") int userId);
    */
    public function getAllReviews($userId) {

        $user = User::find($userId);

        $selections = ['id as reviewId', 'reviewTitle', 'reviewDesc', 'pros', 'cons', 'rating', 'created_at as reviewDate', 'userId', 'productId', 'productName', 'status', 'verified'];

        $data = [];
        if ( count( $user->reviews ) ) {
            
            foreach ($user->reviews()->select('id')->latest()->get() as $review) {
                $data[] = $this->reviewsDto($review->id);
            }            

            return $this->jsonResponse($data, 200);

        }

        return $this->jsonResponse($data, 404, 'No data');

    }

    /*
        @GET("/api/v1/wish-list/{userId}")
        Call<Response> getWishProductListOfUser(@Header("Authorization") String token,
                                                @Path("userId") Integer userId);
    */
    public function getWishProductListOfUser($userId)
    {

        $user = User::find($userId);
        $data = [];
        if ( $user ) {
            
            if ( $user->wishlists()->count() > 0 ) {
                foreach ($user->wishlists()->latest()->get() as $wish) {
                    $data[] = $this->productDTO($wish->productId);
                }

                return $this->jsonResponse($data, 200);
            }else{
                return $this->jsonResponse([], 200, 'No data');
            }

        }

        return $this->jsonResponse($data, 200, 'No data');

    }

    /*
        @GET("/api/v1/wish-list/{userId}/{productId}")
        Call<Response> getWishIdofProduct(@Header("Authorization") String token,
                                          @Path("userId") Integer userId,
                                          @Path("productId") Integer productId);
    */
    public function getWishIdofProduct($userId, $productId)
    {
        $user = User::find($userId);
        $product = Product::find($productId);
        $wishlist = Wishlist::where('userId', $userId)->where('productId', $productId)->first();
        $data = [];
        if ( $user && $product && $wishlist ) {
            
            return $this->jsonResponse($wishlist->id, 200);

        }

        return $this->jsonResponse('', 404, 'No data');
    }

    /*
        @GET("/api/v1/promotionalSales/active")
        Call<Response> getPromotionalSales();
    */
    public function getPromotionalSales()
    {

        $selections = ['id', 'name'];
        $tags = Tags::select($selections)->latest()->get()->take(5);

        if ( count($tags) ) {
            
            foreach ($tags as $tag) {
                $data[] = $this->tagsDTO($tag->id);
            }

            return $this->jsonResponse($data, 200);

        }

        return $this->jsonResponse($data, 404, 'No data.');
    }

    /*
        @GET("/api/v1/promotionalSales/pr/{promotionalSalesId}")
        Call<Response> getPromotionalSalesById(@Path("promotionalSalesId") Integer id);
    */
    public function getPromotionalSalesById($tagid)
    {

        $tag = Tags::find($tagid);
        
        if ( $tag ) {
            
            $data = $this->tagsDTO($tagid);

            $products = [];
            if ( count($tag->products) ) {
                foreach ($tag->products()->inRandomOrder()->pluck('products.id') as $pid) {
                    $data['promotionalProducts'][] = $pid;
                    $data['promotionalProductDtos'][] = $this->productDTO($pid);
                }    
            }

            return $this->jsonResponse($data, 200);

        }

        return $this->jsonResponse([], 404, 'No data');

    }



    private function tagsDTO($tagid)
    {

        $tag = Tags::find($tagid);
        $data = [];
        if ( $tag ) {

            $data['promotionalSalesId'] = $tag->id;
            $data['promotionalTitle'] = $tag->name;            
            $data['promotionalTag'] = $tag->slug;            
            $data['promotionalProducts'] = null;            
            $data['promotionalProductDtos'] = null;
            $data['active'] = true;            

        }

        return $data;

    }

    private function wishlistDTO($id) 
    {
        $selections = ['id', 'userId', 'productId', 'deleted'];

        $wishlist = Wishlist::select($selections)->where('id', $id)->first();

        $wishlist->deleted = $wishlist->deleted ? true : false;

        return $wishlist;
    }

    public function productDTO($productId, $qty = '')
    {

        $selections = ['id', 'productName', 'unit', 'rate', 'categoryId', 'categoryName', 'availableItems', 'parentId', 'featuredImage', 'shortDesc', 'highlights', 'description', 'entryDate', 'quantity', 'featured', 'user_id as userId', 'newProduct', 'merchantId', 'discountPercent', 'actualRate', 'created_at'];

        $product = Product::where('id', $productId)->select($selections)->first();

        $product->featuredImage = url('/') . '/uploads/products/' . $product->featuredImage;
        
        $data = [];

        $data['productId'] = $product->id;
        $data['productName'] = $product->productName;
        $data['unit'] = $product->unit;
        $data['rate'] = (float) $product->rate;
        $data['categoryId'] = $product->categoryId;
        $data['categoryName'] = $product->categoryName;
        $data['availableItems'] = $product->availableItems;
        $data['parentId'] = $product->parentId;

        // Images here
        $data['images'][0]['imageId'] = 1;
        $data['images'][0]['image'] = $product->featuredImage;

        $i = 1;
        if ( count($product->images) ) {
            foreach ($product->images as $img) {
                
                $data['images'][$i]['imageId'] = $i + 1;
                $data['images'][$i]['image'] = url('/') . '/uploads/products/' . $img->image;

                $i++;
            }
        }

        $data['shortDesc'] = $product->shortDesc;
        $data['highlights'] = $product->highlights;
        $data['description'] = $product->description;
        $data['entryDate'] = $product->created_at->format('Y-m-d H:g:s');

        // updated
        $data['quantity'] = $product->quantity;

        $data['featured'] = $product->featured ? true : false;
        $data['userId'] = $product->userId;

        $data['newProduct'] = $product->newProduct ? true : false;
        $data['discountPercent'] = (float) $product->discountPercent;
        $data['actualRate'] = $product->actualRate;
        $data['merchantId'] = (int) $product->merchantId;
        $data['merchant'] = [];

        //Get reviews
        $reviews = [];
        if ( count($product->reviews) ) {
            
            foreach ($product->reviews()->select('id')->get() as $review) {
                $data['reviewDtos'][] = $this->reviewsDto($review->id);
            }

        }else{
            $data['reviewDtos'] = [];    
        }

        //No of reviews
        $data['nosReview'] = $product->reviews()->count();

        // avgRating
        $avgRating = $product->reviews()->avg('rating');
        $data['avgRating'] = $avgRating ? $avgRating : 0;

        // ancestorCategories 
        $ancestorCategories = Category::find($product->categoryId);
        // First current category
        $data['ancestorCategories'][] = $this->categoryDTO($product->categoryId);
        // Then parent category
        if ( $ancestorCategories->parentId != 0 ) {
            $data['ancestorCategories'][] = $this->categoryDTO($ancestorCategories->parentId);
        }else{
            $data['ancestorCategories'] = [];
        }

        $data['totalSoldQuantity'] = 0;
        $data['productTags'] = $product->tags()->pluck('name')->toArray();

        return $data;

    }

public function productDTO_new($productId, $qty = '')
    {

        $selections = ['id', 'productName', 'unit', 'rate', 'categoryId', 'categoryName', 'availableItems', 'parentId', 'featuredImage', 'shortDesc', 'highlights', 'description', 'entryDate', 'quantity', 'featured', 'user_id as userId', 'newProduct', 'merchantId', 'discountPercent', 'actualRate', 'created_at'];

        $product = Product::where('id', $productId)->select($selections)->first();

        $product->featuredImage = url('/') . '/uploads/products/' . $product->featuredImage;
        
        $data = [];

        $data['productId'] = $product->id;
        $data['productName'] = $product->productName;
        $data['unit'] = $product->unit;
        $data['rate'] = (float) $product->rate;
        $data['categoryId'] = $product->categoryId;
        $data['categoryName'] = $product->categoryName;
        $data['availableItems'] = $product->availableItems;
        $data['parentId'] = $product->parentId;

        // Images here
        $data['images'][0]['imageId'] = 1;
        $data['images'][0]['image'] = $product->featuredImage;

        $i = 1;
        if ( count($product->images) ) {
            foreach ($product->images as $img) {
                
                $data['images'][$i]['imageId'] = $i + 1;
                $data['images'][$i]['image'] = url('/') . '/uploads/products/' . $img->image;

                $i++;
            }
        }

        $data['shortDesc'] = $product->shortDesc;
        $data['highlights'] = $product->highlights;
        $data['description'] = $product->description;
        $data['entryDate'] = $product->created_at->format('Y-m-d H:g:s');

        
        $data['quantity'] = $qty;
        
        $data['featured'] = $product->featured ? true : false;
        $data['userId'] = $product->userId;
        // $data['orderQuantity'] = $qty;

        $data['newProduct'] = $product->newProduct ? true : false;
        $data['discountPercent'] = (float) $product->discountPercent;
        $data['actualRate'] = $product->actualRate;
        $data['merchantId'] = (int) $product->merchantId;
        $data['merchant'] = [];

        //Get reviews
        $reviews = [];
        if ( count($product->reviews) ) {
            
            foreach ($product->reviews()->select('id')->get() as $review) {
                $data['reviewDtos'][] = $this->reviewsDto($review->id);
            }

        }else{
            $data['reviewDtos'] = [];    
        }

        //No of reviews
        $data['nosReview'] = $product->reviews()->count();

        // avgRating
        $avgRating = $product->reviews()->avg('rating');
        $data['avgRating'] = $avgRating ? $avgRating : 0;

        // ancestorCategories 
        $ancestorCategories = Category::find($product->categoryId);
        // First current category
        $data['ancestorCategories'][] = $this->categoryDTO($product->categoryId);
        // Then parent category
        if ( $ancestorCategories->parentId != 0 ) {
            $data['ancestorCategories'][] = $this->categoryDTO($ancestorCategories->parentId);
        }else{
            $data['ancestorCategories'] = [];
        }

        $data['totalSoldQuantity'] = 0;
        $data['productTags'] = $product->tags()->pluck('name')->toArray();

        return $data;

    }

    private function categoryDTO($categoryId)
    {

        $selections = ['id as categoryId', 'name as categoryName', 'parentId', 'image', 'featured', 'offered'];

        $category = Category::select($selections)->where('id', $categoryId)->first();

        $category->image = url('/') . '/' . $category->image;
        $category->banner = url('/') . '/' . $category->banner;
        $category->featured = $category->featured ? true : false;
        $category->offered = $category->offered ? true : false;

        if ( $category ) {
            return $category;
        }         

        return [];
    }

    private function reviewsDto($reviewId)
    {

        $selections = ['id as reviewId', 'reviewTitle', 'reviewDesc', 'pros', 'cons', 'rating', 'created_at as reviewDate', 'userId', 'productId', 'productName', 'status', 'verified'];

        $review = Reviews::select($selections)->where('id', $reviewId)->first();

        $data = [];
        if ( $review ) {
                
            $data['reviewId'] = $review->reviewId;
            $data['reviewTitle'] = $review->reviewTitle;
            $data['reviewDesc'] = $review->reviewDesc;
            $data['pros'] = (string) $review->pros;
            $data['cons'] = (string) $review->cons;
            $data['rating'] = $review->rating;
            $data['reviewDate'] = $review->reviewDate;
            $data['userId'] = $review->userId;
            $data['productId'] = $review->productId;
            $data['productName'] = $review->productName;
            $data['userDto'] = $this->userDTO($review->userId);
            $data['status'] = $review->status;
            $data['verified'] = $review->verified ? true : false;

        }

        return $data;

    }

    private function userDto($userId)
    {
        $data = [];

        $user = User::find($userId);
        if ( $user ) {
            
            $data['userId'] = $userId;
            $data['username'] = $user->username;
            $data['fName'] = $user->profile->fName;
            $data['mName'] = $user->profile->mName;
            $data['lName'] = $user->profile->lName;
            $data['email'] = $user->email;      
            $data['phone'] = $user->profile->phone;
            $data['parentId'] = 0;
            $data['authority'] = null;
            $data['roleId'] = $user->roles()->first()->id;  
            $data['token'] = $user->api_token;
            $data['city'] = $user->profile->city;
            $data['street'] = $user->profile->street; 
            $data['enabled'] = $user->suspend ? false : true;
            $data['authorities'] = null; 
        }

        return $data;
    }

    /** Retrieve order details
        @GET("/api/v1/order/{orderId}")
        Call<Response> getOrderDetails(@Header("Authorization") String token,
                                   @Path("orderId") int orderId);
    */
    public function getOrderDetails($orderId)
    {

        $data = $this->orderDTO($orderId);
        
        if ( $data ) {
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No data');
        
    }

    public function getOrderDetails_new($orderId)
    {

        $data = $this->orderDTO_new($orderId);
        
        if ( $data ) {
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No data');
        
    }

    /*  Retrieve all orders
        @GET("/api/v1/order/user/{userId}")
        Call<Response> getAllOrders(@Header("Authorization") String token,
                                    @Path("userId") Integer userId);
    */
    public function getAllOrders($userId) {

        $orders = Order::select('id')->where('ordered_by', $userId)->where('order_status', 1)->orderBy('order_date')->get();

        $data = [];
        if ( count($orders) ) {
            
            foreach ($orders as $order) {
                $data[] = $this->orderDTO($order->id);
            }
            
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No data');

    }

    

    /*
        @POST("/api/v1/order/confirm")
        Call<Response> makeOrder(@Body NewOrderDto newOrderDto);
    */
    public function makeOrder(Request $request)
    {
        $data = '';
        $orderId = 0;
        $returnid = 0;
        $uniqueOrderIdentifier = str_random(18);

        // if(isset( $request->productIds) ){
        if(!empty($request->productIds) && !empty($request->quantities) ) {
        try {
         $email = '';
         $user = (object) $request->user;
         $full_name = $user->fName . ' ' . $user->lName;
         // $email = $request->email;
            // Add shipping details
            if ( $request->shippingAddress ) {
                
                $shippingAddress = (object) $request->shippingAddress;

                if(isset( $shippingAddress->email ) ){
                    $email = $shippingAddress->email;
                }else{
                    $email = '';
                }
                // echo "email : " . $email;
                $returnid = DB::table("shipping_details")->insertGetId([
                    'email' => $email,
                    'client_name' => $full_name,
                    'address' => $shippingAddress->address,
                    'city' => $shippingAddress->city,
                    'state' => $shippingAddress->state,
                    'zipcode' => $shippingAddress->zipcode,
                    'phone' => $shippingAddress->phone,
                    'shipping_type_id' => $shippingAddress->shippingTypeId,
                    'customer_id' => $request->orderedBy,
                ]);

            }

            if ( $request->paymentDetailsId == 1) {
                // $paymentdetail = (object) $request->paymentDetail;
                // $paymentType = $paymentDetail->paymentType;
                $paymentid = DB::table("payment_details")->insertGetId([
                    'payment_method_id' => 1,
                    'amount' => 0,
                    'status' => 0,
                ]);
            }elseif( $request->paymentDetailsId == 3){
                // for payment id
                $paymentid = DB::table("payment_details")->insertGetId([
                    'payment_method_id' => 3,
                    'amount' => 0,
                    'status' => 1,
                ]);
            }else{
                // nothing
            }

            // if($paymentType == 3){
            //     // for payment id if khalti
            //     $paymentid = DB::table("payment_details")->insertGetId([
            //         'payment_method_id' => 2,
            //         'amount' => 0,
            //         'status' => 1,
            //     ]);
            // }

            // else{
            //     // for payment id
            //     $paymentid = DB::table("payment_details")->insertGetId([
            //         'payment_method_id' => 1,
            //         'amount' => 0,
            //         'status' => 0,
            //     ]);
            // }
            
        } catch (Exception $exception) {
            $errormessage = $exception->getMessage();

            return $this->jsonResponse($data, 404, $errormessage);
        }

        try {
            
            // Order
            $order = new Order;

            $order->order_date = date('Y-m-d');
            $order->shipping_details_id = $returnid;
            // $order->payment_details_id = $request->paymentDetailsId;
            $order->payment_details_id = $paymentid;
            // $order->order_status = $request->orderStatus;
            $order->ordered_by = $request->orderedBy;
            $order->unique_order_identifier = $uniqueOrderIdentifier;

            $order->save();
            
            $orderId = $order->id;

        } catch (Exception $exception) {
            $errormessage = $exception->getMessage();

            return $this->jsonResponse($data, 404, $errormessage);
        }

        try {
            
            $productIds = $request->productIds;
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
                    // newly added
                    $OrderDetail->rate = $rates->rate;

                    $OrderDetail->save();

                }

            }

            

        } catch (Exception $exception) {
            
            $errormessage = $exception->getMessage(); 
            return $this->jsonResponse($data, 404, $errormessage);

        }

        $data = $this->orderDTO($orderId);

        if ( $data ) {
            return $this->jsonResponse($data, 200);
        }else{
            return $this->jsonResponse([], 404, 'Invalid Order.');
        }
        }else{
            return $this->jsonResponse([], 404, 'Invalid Order. Product is Required');
        }

    }

    private function orderDTO($orderId)
    {

        $selections = [
                        'id as orderId', 
                        'order_details.product_id as productId', 
                        'order_date as orderDate', 
                        'order_status as orderStatus',
                        'shipping_details_id as shippingDetailsId',
                        'payment_details_id as paymentDetailsId',
                        'ordered_by as orderedBy',
                        'quantity'
                    ];

        $order = Order::select($selections)
                        ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                        ->where('id', $orderId)
                        ->first();
        return $order;

    }

    private function orderDTO_new($orderId)
    {

        $selections = [
                        'id as orderId', 
                        'order_details.product_id as productId', 
                        'order_date as orderDate', 
                        'order_status as orderStatus',
                        'shipping_details_id as shippingDetailsId',
                        'payment_details_id as paymentDetailsId',
                        'ordered_by as orderedBy',
                        'quantity as quantities',
                        'order_details.order_details_id as orderDetailsId'
                    ];

        $order = Order::select($selections)
                        ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                        ->where('orders.id', $orderId)
                        ->get();

                        $data = [];
                        foreach ($order as $o) {

                            $data[] = $this->productDTO_new($o->productId, $o->quantities);
                        }
        return $data;

    }

    // private function orderDTO_new($orderId)
    // {

    //     $selections = [
    //                     'order_new.id as orderId', 
    //                     'order_detail_new.productId as productId', 
    //                     'order_date as orderDate', 
    //                     'paymentStatus as orderStatus',
    //                     'shippingAddress as shippingAddress',
    //                     'phone as phone',
    //                     'city as city',
    //                     'paymentType as paymentType',
    //                     'paymentStatus as paymentStatus',
    //                     // 'quantity'
    //                 ];

    //     $order = OrderNew::select($selections)
    //                     ->join('order_detail_new', 'order_detail_new.orderId', '=', 'order_new.id')
    //                     ->where('order_new.id', $orderId)
    //                     ->first();
    //     return $order;

    // }

    private function jsonResponse($data, $status, $message = 'Success')
    {

        return response()->json([
                                    'data' => $data,
                                    'currentNo' => 0,
                                    'startNo' => 0,
                                    'endNo' => 0,
                                    'status' => $status,
                                    'message' => $message]
                                )->setStatusCode($status);

    }

    public function storeProduct(Request $request)
    {
        $data = '';
        
        try {
         
            // Add shipping details
            // if ( $request->storeProduct ) {
                // $storeProduct = (object) $request->storeProduct;
                // 'id', 'productName', 'unit', 'rate', 'categoryId', 'categoryName', 'availableItems', 'parentId', 'featuredImage', 'shortDesc', 'highlights', 'description', 'entryDate', 'quantity', 'featured', 'user_id as userId', 'newProduct', 'discountPercent', 'actualRate', 'created_at'
                $ffname = '';
                $returnid = DB::table("products")->insertGetId([
                    'productName' => $request->productName,
                    'slug' => str_slug($request->productName),
                    'featuredImage' => $ffname,
                    'quantity' => $request->quantity,
                    'unit' => $request->unit,
                    "rate" => $request->rate,
                    "actualRate" => $request->actualRate,
                    "categoryId" => $request->categoryId,
                    "categoryName" => $request->categoryName,
                    "avgRating" => 0,
                    "shortDesc" => $request->shortDesc,
                    "description" => $request->description,
                    "entryDate" => date('Y-m-d'),
                    "created_at" => date('Y-m-d H:g:s'),
                    "user_id" => $request->user_id,
                    "merchantId" => $request->merchantId,
                    "availableItems" => $request->availableItems,
                    "featured" => $request->featured,
                    "user_id" => $request->userId,
                    "newProduct" => 1,
                    "discountPercent" => $request->discountPercent,
                ]);

                if ( $returnid ) {
                    return $this->jsonResponse($returnid, 200);
                }else{
                    return $this->jsonResponse([], 404, 'Invalid Order.');
                }
            // }

        } catch (Exception $exception) {
            $errormessage = $exception->getMessage();

            return $this->jsonResponse([], 404, $errormessage);
        } 
    }

    public function uploadProductImages(Request $request, $id)
    {
        $productImages = $request->file('productImages');
        
        $product = Product::find($id);
        
        if ( $productImages && $product ) {

            try {
                
                $count = 0;
                $filenames = [];
                $ffname = '';
                ini_set('memory_limit', '256M');
                foreach ($productImages as $image) {
                    if ( $count == 0 ) {
                        
                        $ffname = 'featured-' . str_slug( $product->productName ) . '-' . str_random(8) . '.' . $image->getClientOriginalExtension();
                        Image::make($image)->resize(270, 270)->save('uploads/products/'. $ffname);
                        Image::make($image)->resize(185, 185)->save('uploads/products/thumbnails/'. $ffname);
                    
                    }else{
                        
                        $newfilename = str_slug( $product->productName ) . '-' . $image->getSize() . str_random(8) . '.'. $image->getClientOriginalExtension();
                        $filenames[] = $newfilename;

                        Image::make($image)->resize(270, 270)->save('uploads/products/'. $newfilename);
                        Image::make($image)->resize(185,185)->save('uploads/products/thumbnails/'. $newfilename);

                    }
                    $count++;
                }

                $product->featuredImage = $ffname;
                $product->save();

                if( $productImages ){

                    foreach ($filenames as $f) {
                        $img = new Productimage;
                        
                        $img->product_id = $product->id;
                        $img->image = $f;

                        $img->save();
                    }

                }

                if ( $count > 0 ) {
                    return $this->jsonResponse([], 200);
                }

            } catch (Exception $e) {
                $errormessage = $exception->getMessage();

                return $this->jsonResponse([], 404, $errormessage);
            }

            
        }

        return $this->jsonResponse([], 404, 'Cannot upload, no Images received or product not found.');

    }

    public function get_unit_types()
    {

        $data = [
            ['unit' => 'Pieces', 'value' => 'pcs'],
            ['unit' => 'Package', 'value' => 'package'],
            ['unit' => 'Set', 'value' => 'set'],
            ['unit' => 'Dozen', 'value' => 'dozen'],
            ['unit' => 'Kg', 'value' => 'kg'],
        ];

        return $this->jsonResponse($data, 200);

    }  

    public function getAllOrdersAdmin() {

        $orders = Order::select('id')->where('order_status', 1)->latest()->get();
        
        $data = [];
        if ( count($orders) ) {
            
            foreach ($orders as $order) {
                $data[] = $this->orderDTO($order->id);
            }
            
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No data');

    }

    public function getAllCancelledOrdersAdmin() {

        $orders = Order::select('id')->where('order_status', 0)->orderBy('order_date')->get();

        $data = [];
        if ( count($orders) ) {
            
            foreach ($orders as $order) {
                $data[] = $this->orderDTO($order->id);
            }
            
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No data bb');

    }

    public function cancel_order(Request $request, $order_id){
    

        $o = Order::where('id', $order_id)->update(['order_status' => 0]);

        if ( $o ) {
            $data = $this->orderDTO($order_id);
            return $this->jsonResponse($data, 200);
        }else{
            return $this->jsonResponse([], 404, 'Invalid Order.');
        }
    }

    public function getAllCancelledOrders($userId) {

        $orders = Order::select('id')->where('ordered_by', $userId)->where('order_status', 0)->orderBy('order_date')->get();

        $data = [];
        if ( count($orders) ) {
            
            foreach ($orders as $order) {
                $data[] = $this->orderDTO($order->id);
            }
            
            return $this->jsonResponse($data, 200);
        }

        return $this->jsonResponse($data, 404, 'No data');

    }

    public function verifyKhaltiPayment(Request $request)
    {

        $args = http_build_query(array(
            // 'token' => $khalti->pre_token,
            // 'amount'  => ($khalti->amount * 100)
            'token' => $request->token,
            'amount'  => ($request->amount)
        ));

        $url = "https://khalti.com/api/payment/verify/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key test_secret_key_206b9b6e5059419aa8451f94404707d5'];
        // $headers = ['Authorization: Key live_secret_key_393dec13dc484b939f73b81473e639e2'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $token = json_decode($response, TRUE);
        // if (isset($token['idx'])&& $status_code == 200) 
        if ($status_code == 200) 
        {
            
            return $this->jsonResponse($response, 200, 'Successful.');
            
        }
       
        return $this->jsonResponse($response, $status_code, 'Something went Wrong , Try Again !!');

    }

    public function getSearchProduct($productName, Request $request) {
        $last_seen = $request->last_seen;
        $pageSize = $request->pageSize;
        $action = $request->action;

        $data = [];
        
        if($last_seen == 0){
            // $products = DB::table('order_details')->select('product_id')->groupBy('product_id')->orderBy('product_id', 'desc')->get()->take($pageSize);

            $products = Product::where('productName', 'like', '%'.$productName.'%')->latest()->get()->take($pageSize);
        }else{
            if($action == "first"){
                // nothing

                $products = Product::where('productName', 'like', '%'.$productName.'%')->where('id', '<', $last_seen)->latest()->get()->take($pageSize);

            }elseif($action == "next"){
                $products = Product::where('productName', 'like', '%'.$productName.'%')->where('id', '<', $last_seen)->latest()->get()->take($pageSize);
            }else{
                $products = Product::where('productName', 'like', '%'.$productName.'%')->where('id', '<', $last_seen)->latest()->get()->take($pageSize);
            }
            
        }

        

        if ( count($products) ) {
        
            foreach ($products as $product) {
                $data[] = $this->productDTO($product->id);
            }
            return $this->jsonResponse($data, 200);
        }else{
            return $this->jsonResponse($data, 200, 'No data.');
        }
    }

    
    public function saveToken(Request $request){

        $tokens = DB::table('deviceToken')->select('id')->where('token', '=', $request->token)->get();

        if(count($tokens)){
            
            $k = DB::table('deviceToken')
                ->where('id', $tokens[0]->id)
                ->update(['device' => $request->device,  'status' => $request->status]);
        }else{
            
            $k = DB::table('deviceToken')->insert([
                ['user_id' => $request->userId, 'device' => $request->device, 'token' => $request->token, 'status' => $request->status]
            ]);
        }
        
        if($k){
            return $this->jsonResponse([], 200, 'Successful.');
        }else{
            return $this->jsonResponse([], 200, 'Unsuccessful');
        }

    }

    public function getDeviceToken(){
        $token = DB::table('deviceToken')->latest()->get();

        return $token;
    }

    public function notification($token='/topics/allDevices', $title="के तपाई पाथिभरा हार्डवयर भिजिट गर्नुभयो?.")
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token=$token;

        $notification = [
            'title' => $title,
            'body' => "Checkout Our New Product : Wristwatch",
            'sound' => true,
            'icon' => "chapter/icon_a22.png",
            // 'click_action' => 'http://pathivarahardware.com/api/products/168'
        ];
        
        
        $data = [
            'to'        => '/topics/allDevices', //single token
            'notification'        => $notification, 
            // 'message' => "के तपाईले आफ्नो बाथरुममा धारा जडान गर्नुभयो?",
        ];

        $headers = [
            'Authorization: key=AAAAjWLDEng:APA91bEW2DFgu4ToytgxDozE52yzoLbiBurpt403oHQbzRJr22CisNLiSip2bGqOI9zE_z5z8-r9khmXbJdUP_6PR8Y7nYAkg2Owwf3TRd3v0I76upue--UUQNHl8ZVP20jviztrjdKd',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        curl_close($ch);

        return true;
    }

    // extra details
    public function getextraDetails($orderId) {
        $data = [];
        
        $data = $this->extraDetails($orderId);
        // $data[] = $order;
        // return $order;
        if($data){
            return $this->jsonResponse($data, 200, 'Success');
        }else{
            return $this->jsonResponse([], 200, 'No data');
        }
        
    }

    public function insert_product_review(Request $request){

        
        if ($request->reviewTitle) {
            if($request->userId){
                $user = User::find($request->userId);
                $email = $user->email;
            }
            $productN = Product::find($request->productId);
            $productName = $productN->productName;

            $review = new Reviews;
            
            $review->reviewTitle = $request->reviewTitle;
            // $review->email = $request->email;
            $review->reviewDesc = $request->reviewDesc;
            $review->rating = $request->rating;
            $review->userId = $request->userId;
            $review->email = $email;
            $review->productId = $request->productId;
            $review->productName = $productName;

            $review->save();

            $product = Product::where('id', $request->productId)->first();

            $nosreviews = $product->nosReview;

            $product->nosReview = $nosreviews + 1;

            $product->save();
        }
        
        if ($request->rating) {
            DB::table('ratings')->insert([
                                            'user_id' => $request->userId,
                                            'product_id' => $request->productId,
                                            'rating' => $request->rating,
                                        ]);
        }

        if($review){
            return $this->jsonResponse([], 200, 'Successful.');
        }else{
            return $this->jsonResponse([], 200, 'Unsuccessful');
        }

    }

    public function extraDetails($orderId){
        $selections = [
                        'id as orderId', 
                        'payment_details.amount as totalCost',
                        'shipping_details.client_name as customerName',
                        'shipping_details.email as customerEmail',
                        'shipping_details.address as customerAddress',
                        'shipping_details.phone as customerPhoneNo',
                        'payment_details.status as paymentStatus',
                    ];

        $order = Order::select($selections)
                        
                        ->join('payment_details', 'payment_details.payment_id', '=', 'orders.payment_details_id')
                        ->join('shipping_details', 'shipping_details.shipping_details_id', '=', 'orders.shipping_details_id')
                        ->where('orders.id', $orderId)
                        ->first();
                        
        $total_cost = DB::table('order_details')->select('quantity', 'rate')->where('order_id', $orderId)->get();
        if($total_cost){
            $cc = 0;
            foreach ($total_cost as $val) {
                $price = $val->quantity * $val->rate;
                $cc += $price;
            }
        }else{
            $cc = 0;
        }
        

        $pay = 0;
        if($order){
            if($order->paymentStatus == 1){
                $pay = 'Paid';
            }elseif($order->paymentStatus == 0){
                $pay = 'Pending';
            }else{
                $pay = 'N/A';
            }

            $data['orderId'] = $order->orderId;
            $data['customerName'] = $order->customerName;
            $data['customerEmail'] = $order->customerEmail;
            $data['customerAddress'] = $order->customerAddress;
            $data['customerPhoneNo'] = (string) $order->customerPhoneNo;
            $data['paymentStatus'] = $pay;
            $data['totalCost'] = (string) $cc;

        }else{
            $data = '';
        }

        return $data;
    }

        public function wishlist_update(Request $request) {

        $productid = $request->productId;
        $userId = $request->userId;

        $user_details = User::find($userId);

        if ( $user_details ) {
            
            // $userid = Auth::id();

            $check = Wishlist::where('userId', $userId)->where('productId', $productid)->first();
            // $message = '';
            if($check){
            if($request->deleted == false){
                // add to wishlist
                $check = Wishlist::where('userId', $userId)->where('productId', $productid)->first();
                $check->deleted = 0;
                
                $message = 'Added to Wish List.';

                $check->save();
                $data = $this->wishlistDTO($check->id);

                return $this->jsonResponse($data, 200, $message);

            }else{
                // remove from wishlist
                $check = Wishlist::where('userId', $userId)->where('productId', $productid)->first();
                $check->deleted = 1;

                $message = 'Removed from your Wish List.';

                $check->save();

               
                $data = $this->wishlistDTO($check->id);
                return $this->jsonResponse($data, 200, $message);
            }
        }else{
            $product = Product::find($productid);

                if($product){
                    $wish = new Wishlist;

                    $wish->userId = $userId;
                    $wish->productId = $productid;

                    $wish->save();

                    $data = $this->wishlistDTO($wish->id);
                    return $this->jsonResponse($wish->id, 200, 'Added to Wish List.');
                }else{
                    return $this->jsonResponse([], 200, 'Product Not Found');
                    
                }
            }

        }else{

            return $this->jsonResponse([], 200, 'User Not Found');

        }

    }

    public function wishlist_delete($wishId) {

        $wishId = $wishId;
        $wishlist = Wishlist::where('id', $wishId)->delete();

        if($wishId){
        if($wishlist){
            return $this->jsonResponse([], 200, 'Wishlist Removed');
        }else{
            return $this->jsonResponse([], 200, 'Sorry! Could not Remove Wishlist.');
        }
        }else{
            return $this->jsonResponse([], 200, 'No Data');
        }
        

    }
    
}
