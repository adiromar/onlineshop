<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Merchant;
use DB;
use Session;
use Illuminate\Support\Str;

use App\Mail\VerifyEmail;

class MerchantController extends Controller
{
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
        $this->validateWith([
            'firstName' => 'required|string|alpha|max:255',
            'lastName' => 'required|string|alpha|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|alpha_dash|max:255|unique:users',
            'password' => 'required|string|min:6|regex:/^(?=(.*[a-zA-Z].*){2,})(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{4,15}$/|confirmed',
            'terms' => 'required',
            'streetAddress' => 'required',
            'city' => 'required',
            'phoneNumber' => 'required|integer|regex:/\\A[0-9]{10}\\z/'
          ]);

        if ( $request->is_merchant ) {
            $is_merchant = 1;

            if ( $request->panCard || $request->vatRegistration ) {

            }else{
                Session::flash('info', 'Either PAN Card or VAT Registration Certificate is required if you are a wholeseller.');
                return redirect()->back()->withInput()->withErrors("message", "Either PAN Card or VAT Registration Certificate is required if you are a wholeseller.");
            }

        }

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
            'role_id' => 2,
        ]);

          $merchant = new Profile;

          $merchant->user_id = $uid;
          $merchant->fName = $request->firstName;
          $merchant->mName = $request->middleName;
          $merchant->lName = $request->lastName;
          $merchant->street = $request->streetAddress;
          $merchant->city = $request->city;
          $merchant->phone = $request->phoneNumber;

        $ffname = $fffname = null;
        if ( $request->is_merchant ) {

            // PAN CARD
            if ( $request->file('panCard') ) {
                $panImage = $request->file('panCard');
                $ffname = 'pan-' . str_slug( $request->username ) . '-' . str_random(8) . '.' . $panImage->getClientOriginalExtension();

                $panImage->move('uploads/wholeseller/pan', $ffname);
            }

            // PAN CARD
            if ( $request->file('vatRegistration') ) {
                $vatImage = $request->file('vatRegistration');
                $fffname = 'vat-' . str_slug( $request->username ) . '-' . str_random(8) . '.' . $vatImage->getClientOriginalExtension();

                $vatImage->move('uploads/wholeseller/vat', $fffname);
            }

            $merchant->panCard = $ffname;
            $merchant->vatCard = $fffname;
        }


          $merchant->save();

        $to = $request->email;
        $verificationlink = route('verify.email', [$uid, $token]);
        $data = [];
        $data['emailName'] = $to;
        $data['username'] = $request->username;
        $data['verificationlink'] = $verificationlink;
        $data['fromEmail'] = "info@chaiyo.shop";
        $data['fromName'] = "Chaiyo Shop Nepal";
        $data['emailSubject'] = "Verify Merchant Account | Chaiyo.Shop";

        $data = (object) $data;

        try {
          \Mail::to($to)->send( new VerifyEmail($data) );
        } catch (Exception $e) {
            Session::flash('info', 'Invalid Email. Please contact us for verification.');
            return redirect()->back();
        }

        Session::flash('info', 'An email has been sent to your address. Please follow further instructions. Thanks!');

        return redirect()->back();
    }

    public function merchant_verification($id, $token) {

      $user = User::where('id', $id)->where('verifyToken', $token)->firstOrFail();

      $user->suspend = 1;
      $user->verifyToken = null;

      $user->save();

      $profile = $user->profile;

      $checkprofile = Profile::orderBy('created_at', 'desc')->where('uuID', '>', 0)->first();

      if ( $checkprofile ) {
        $profile->uuID = $checkprofile->uuID + 1;
      }else{
        $profile->uuID = 1;
      }

      $profile->save();

      Session::flash('success', 'You have been Registered. Our Admins will verify your documents and get back to you soon. Thanks!');

      return redirect('/');

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
        $merchant = Merchant::find($id);

        return view('merchant.edit', compact('merchant'));
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
        if($request->verified == 1){
        $merchant = Merchant::find($id);

        $user = new User;
        $user->username = $merchant->firstName;
        $user->email = $merchant->email;
        $user->password = bcrypt($merchant->password);
        $user->save();

        $uid = $user->id;

        // Update Profile Table
        $profile = new Profile;

        $profile->user_id = $uid;
        $profile->fName = $merchant->firstName;
        $profile->mName = $merchant->middleName;
        $profile->lName = $merchant->lastName;
        $profile->street = $merchant->streetAddress;
        $profile->city = $merchant->city;
        $profile->phone = $merchant->phoneNumber;

        $profile->save();

        DB::table('role_user')->insert([
            'user_id' => $uid,
            'role_id' => 2,
        ]);

        Merchant::where('id', $request->merchant_id )->update([ 'accountVerified' => 1 ]);

        session()->flash('success', 'Supplier/Merchant has been Approved.');

        }
        return redirect('admin/merchant-list');
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

    public function fetch_rec(Request $request){
        $catId = $request->cat_id;
        $parent = Merchant::where('id', $catId)->get();

        $filter = $parent;
        // return $this->jsonResponse(['success' => true, 'html' => $html]);

        $html = view('merchant.merchant_update')->with(compact('filter'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }
}
