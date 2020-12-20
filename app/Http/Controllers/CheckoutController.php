<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\User;
use Mail;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.cart.checkout');
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
        // dd($request);
        $this->validateWith([
            'username' => 'required',
            'delivery_address' => 'required',
            'user_email' => 'required',
            'number' => 'required',
            'product_id' => 'required'
        ]);

        $productids = $request->product_id;
        $supplierids = $request->supplier_id;
        
        // dd($supplierids);
        // print_r($productids);print_r($supplierids);die;
        $arr = array_combine($productids,$supplierids);
        // dd($arr);
        foreach ($arr as $key => $value) {
          Orders::insert([
                    'product_id' => $key,
                    'user_id' => $value,
                    'name' => $request->username,
                    'user_email' => $request->user_email,
                    'phone' => $request->number,
                    'address' => $request->delivery_address,
                    'theme_no' => $request->theme_no,
          ]);
        }
        // $sids = array_unique($request->supplier_id);
        // foreach ( $sids as $s ) 
        // {
            
        //     $user = User::find($s);
        //     if ($user->profile) {
        //     session(['uemail' => $user->profile->email]);
        //     }else{
        //     session(['uemail' => $user->email]);
        //     }
        //     //Start Email
        //     try {
        //         Mail::send('emails.orders.shipped', 
        //                   [ 
        //                     'user_name' => $user->name, 
        //                     'clientname' => $request->username,
        //                   ]
        //                   , function ($message)
        //                     {

        //                         $message->from('sastoshowroom@gmail.com', 'Sastoshowroom');
        //                         $message->cc('nickarsenal007@gmail.com', $name = null);
        //                         $message->subject('Order Alert! Sastoshowroom');
        //                         $message->to(session()->get('uemail'));

        //                     });
        //       } catch (Exception $e) {   }
        //       sleep('1');
        //       session()->forget('uemail');
        // }

        session()->flash('info', 'Thank you for placing your orders. We will contact you soon.');
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
