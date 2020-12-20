<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;
use Session;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateWith([
          'couponCode' => 'required|alpha_num|unique:tbl_coupons',
          'type' => 'required',
          'discountPrice' => 'required',
          'minPrice' => 'required'
        ]);

        $data = new Coupon;

        $data->couponCode = $request->couponCode;
        $data->type = $request->type;
        $data->discountPrice = $request->discountPrice;
        $data->minPrice = $request->minPrice;

        $data->save();

        Session::flash('success', 'Succesfully added.');

        return redirect()->route('coupons.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->validateWith([
          'couponCode' => 'required|alpha_num',
          'type' => 'required',
          'discountPrice' => 'required',
          'minPrice' => 'required'
        ]);

        $coupon->couponCode = $request->couponCode;
        $coupon->type = $request->type;
        $data->discountPrice = $request->discountPrice;
        $coupon->minPrice = $request->minPrice;

        $coupon->save();

        Session::flash('success', 'Succesfully updated.');

        return redirect()->route('coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }
}
