<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use App\User;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereHas('roles' , function($query){
          $query->where('role', 'Supplier');
        })->with('profile')->get();

        return view('admin.suppliers', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profile = Auth::user()->profile;
        // dd($profile);
        return view('suppliers.create', compact('profile'));
    }

    public function edit_perm($id) {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.editperm', compact('supplier'));
    }

    public function update_perm($id, Request $request) {
        $supplier = Supplier::findOrFail($id);

        if ( $request->view_order ) {
            $supplier->view_order = 1;
        }else{
            $supplier->view_order = 0;
        }
        if ( $request->view_paid_order ) {
            $supplier->view_paid_order = 1;
        }else{
            $supplier->view_paid_order = 0;
        }

        $supplier->save();

        return redirect()->back();

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
                            'shopname' => 'required|bail',
                            'about_us' => 'required|bail',
                            'contactEmail' => 'required|bail',
                            'address' => 'required',
                            'featured_image' => 'required|image',
                            'phone' => 'required',
                        ]);


        //Upload file and get imagename
        $file = $request->file('featured_image');
        $filename = time() . '-' . str_slug($request->shopname) . '.'.$file->getClientOriginalExtension();

        $file->move('uploads/suppliers', $filename);

        // pan
        $file_1 = $request->file('pan');
        if($file_1){
            $filename_1 = time() . '-' . str_slug($request->shopname) . '.'.$file_1->getClientOriginalExtension();
            $file_1->move('uploads/suppliers/pan', $filename_1);
        }
        // vat
        $file_2 = $request->file('vat');
        if($file_2){
            $filename_2 = time() . '-' . str_slug($request->shopname) . '.'.$file_2->getClientOriginalExtension();
            $file_2->move('uploads/suppliers', $filename_2);
        }

        $profile = new Supplier;

        $profile->user_id = Auth::id();
        $profile->detail = $request->shopname;
        $profile->about_us = $request->about_us;
        $profile->email = $request->contactEmail;
        $profile->address = $request->address;
        $profile->image = 'uploads/suppliers/' . $filename;
        $profile->phone = $request->phone;
        $profile->facebook_link = $request->facebook_link;
        $profile->viber = $request->viber;
        $profile->skype = $request->skype;
        $profile->wechat = $request->wechat;

        $profile->save();

        return redirect()->route('dashboard');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = DB::table('suppliers')->where('user_id', $id)->first();
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validateWith([
                            'shopname' => 'required|bail',
                            'about_us' => 'required|bail',
                            'contactEmail' => 'required|bail',
                            'address' => 'required',
                            'phone' => 'required',
                        ]);

        $profile = Supplier::findOrFail($id);

        //Upload file and get imagename
        $file = $request->file('featured_image');
        $fileurl = $profile->image;
        if ( $file ) {

            $filename = time() . '-' . str_slug($request->shopname) . '.'.$file->getClientOriginalExtension();

            if ( file_exists($profile->image) ) {
                unlink($profile->image);
            }

            $file->move('uploads/suppliers', $filename);

            $fileurl = 'uploads/suppliers/' . $filename;

        }

        //Upload file and get pan
        $file_1 = $request->file('pan');
        $fileurl_1 = $profile->pan;
        if ( $file_1 ) {

            $filename1 = time() . '-' . str_slug($request->shopname) . '.'.$file_1->getClientOriginalExtension();

            if ( file_exists($profile->pan) ) {
                unlink($profile->pan);
            }

            $file_1->move('uploads/suppliers/pan', $filename1);

            $fileurl_1 = 'uploads/suppliers/pan/' . $filename1;

        }

        //Upload file and get vat
        $file_2 = $request->file('vat');
        $fileurl_2 = $profile->vat;
        if ( $file_2 ) {

            $filename2 = time() . '-' . str_slug($request->shopname) . '.'.$file_2->getClientOriginalExtension();

            if ( file_exists($profile->vat) ) {
                unlink($profile->vat);
            }

            $file_2->move('uploads/suppliers/vat', $filename2);

            $fileurl_2 = 'uploads/suppliers/vat/' . $filename2;

        }

        $profile->user_id = Auth::id();
        $profile->detail = $request->shopname;
        $profile->about_us = $request->about_us;
        $profile->email = $request->contactEmail;
        $profile->address = $request->address;
        $profile->image = $fileurl;
        $profile->phone = $request->phone;
        $profile->facebook_link = $request->facebook_link;
        $profile->viber = $request->viber;
        $profile->skype = $request->skype;
        $profile->wechat = $request->wechat;

        $profile->pan = $fileurl_1;
        $profile->vat = $fileurl_2;

        $profile->save();

        Session::flash('success', 'Succesfully updated.');

        return redirect()->route('dashboard');

    }

    public function show($id) {

      $user = User::findOrFail($id);
      return view('suppliers.show', compact('user'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
