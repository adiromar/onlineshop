<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\User;
use App\Profile;
use App\Coupon;
use DB;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.cart.index');
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

        $duplicates = Cart::search(function ($cartItem, $rowId) use($request) {
            return $cartItem->id === $request->id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success', 'Item is already in your cart.');
        }

        Cart::add($request->id, $request->name, 1, $request->price)
                ->associate('App\Product');

        return redirect()->back();
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
        Cart::instance('default')->update($id, $request->item_count);

        session()->flash('success', 'Succesfully updated your item count.');
        return redirect()->back();
    }

    public function itemIncrement(Request $request, $id)
    {
        $item = $request->item_count + 1;
        Cart::instance('default')->update($id, $item);

        session()->flash('success', 'Succesfully updated your item count.');
        return redirect()->back();
    }

    public function itemDecrement(Request $request, $id)
    {
        Cart::instance('default')->update($id, $request->item_count-1);

        session()->flash('success', 'Succesfully updated your item count.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);

        session()->flash('success', 'Succesfully removed the item.');

        return redirect()->back();
    }

    public function check_send_gift(Request $request) {

      $uname = $request->uname;
      $phone = $request->phone;
      $code = $request->code;

      $coupon = Coupon::where('couponCode', $code)->count();


      if ( $coupon > 0 ) {

        $user = User::where('username', $uname)->first();
        if ( $user ) {
          $chk = DB::table('tbl_coupons_users')->where('user_id', Auth::id())->where('couponCode', $code)->count();

          if ($chk > 0) {
            return response()->json(['status' => 404]);
          }

          $profile = Profile::where('user_id', $user->id)->where('phone', $phone)->count();

          if ( $profile > 0 ) {

            return response()->json(['status' => 200, 'data' => $user]);

          }

        }

      }else{
        return response()->json(['status' => 404]);
      }

      return response()->json(['status' => 400]);

    }

    public function send_gift_code(Request $request) {

      $code = $request->code;
      $sentTo = $request->sentTo;
      $sentBy = $request->sentBy;

        DB::table('tbl_coupons_users')->insert([
          'user_id' => $sentBy,
          'sentTo' => $sentTo,
          'couponCode' => $code
        ]);

        return response()->json(['status' => 200, 'data' => $request->all()]);

    }

}
