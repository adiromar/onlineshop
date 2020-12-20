<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use DB;
use App\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login_custom(Request $request) {
      
      $user = User::where('email', $request->email)->first();

      if ( $user->suspend == 1 ) {
        return redirect()->back()->withInput()->withErrors(['Your account has not been verified yet.']);
      }
      
      if ( !Auth::attempt(['email' => $request->email, 'password' => $request->password, 'suspend' => 0]) )
      {
          return redirect()->back()->withInput()->withErrors(['Wrong credentials. Please try again!']);;
      }

      // Authentication passed...
      return redirect()->intended('admin');
      

    }

    public function redirectToFacebookProvider(){
        try {
          return Socialite::driver('facebook')->redirect();
        } catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
          die;
        }


    }

    public function handleProviderCallback(Request $request)
    {
      try {
        // $data = session('product_id');
        // $slug = session('product_slug');

        try {
              $userSocial = Socialite::driver('facebook')->user();
          } catch (InvalidStateException $e) {
              echo 'Caught exception: ',  $e->getMessage(), "\n";
        		die; 
          }
        $userEmail = $userSocial->user['email'];
        if (empty($userEmail)) {
            $userEmail = 'default@example.com';
        }
        $user = User::where('email', $userEmail)->first();

        if ($user)
        {
            if (Auth::loginUsingId($user->id, true)) {
                $request->session()->flash('success', "You are now logged in.");
                // if (empty($data) || empty($slug)) {
                //     return redirect()->back();
                // }
                // return redirect()->route('view.product', [$slug]);
                return view('/');
            }
        }
        else
        {
            $userSignup = User::create([
                    'name' => $userSocial->user['name'],
                    'email' => $userEmail,
                    'password' => bcrypt($userSocial->user['id']),
            ]);
            $uid = $userSignup->id;

            DB::table('role_user')->insert([
                                            'user_id' => $uid,
                                            'role_id' => 3
                                         ]);

            if ($userSignup)
            {
              if (Auth::loginUsingId($userSignup->id, true))
              {
                if (empty($data)) {
                    session()->flash('success', 'You are now logged in.');
                    session()->flash('info','Slow internet connected detected. We could not redirect you to the product page.');
                    return redirect()->back();
                }
                $request->session()->flash('success', "You are now logged in.");
                // return redirect()->route('view.product', [$slug]);
                return view('/');
              }
            }
        }

        $request->session()->flash('error', "Something went wrong. Please try again with correct credentials");
        return redirect()->back();
      } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        die;
      }


    }


}//Main class loop
