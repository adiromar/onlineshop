<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;
use Auth;

class ProfileController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.profile');
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
                            'detail' => 'required|bail',
                            'about_us' => 'required|bail',
                            'email' => 'required|bail',
                            'address' => 'required',
                            'image' => 'image',
                            'phone' => 'required',
                        ]);

        //Upload file and get imagename
        $file = $request->file('image');
        $filename = time() . $file->getSize().'.'.$file->getClientOriginalExtension();

        $file->move('uploads/suppliers', $filename);

        $profile = new Profile;

        $profile->user_id = Auth::id();
        $profile->detail = $request->detail;
        $profile->about_us = $request->about_us;
        $profile->email = $request->email;
        $profile->address = $request->address;
        $profile->image = $filename;
        $profile->phone = $request->phone;
        $profile->facebook_link = $request->facebook_link;
        $profile->viber = $request->viber;
        $profile->skype = $request->skype;
        $profile->wechat = $request->wechat;

        $profile->save();

        return redirect()->route('dashboard');
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
        return view('user.profile.edit')->with('profile', User::find($id));
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
        
        $this->validateWith([
                            'detail' => 'required|bail',
                            'about_us' => 'required|bail',
                            'email' => 'required|bail',
                            'address' => 'required',
                            'image' => 'image',
                            'phone' => 'required',
                        ]);

        $profile = Profile::find($id);

        //Upload file and get imagename
        if ($request->image) {
            $file = $request->file('image');
            $filename = time() . $file->getSize().'.'.$file->getClientOriginalExtension();
            unlink('uploads/suppliers/'.$profile->image);
            $file->move('uploads/suppliers', $filename);
        }

        $profile->detail = $request->detail;
        $profile->about_us = $request->about_us;
        $profile->email = $request->email;
        $profile->address = $request->address;
        if ($request->image) {
            $profile->image = $filename;
        }
        $profile->phone = $request->phone;
        $profile->facebook_link = $request->facebook_link;
        $profile->viber = $request->viber;
        $profile->skype = $request->skype;
        $profile->wechat = $request->wechat;

        $profile->save();

        return redirect()->route('dashboard');
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
