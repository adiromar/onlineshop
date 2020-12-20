<?php
namespace App\Http\Controllers\ApiAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Profile;

class LoginController extends Controller
{
	use AuthenticatesUsers;

	/*
		@POST("/login")
        Call<Response> login(@Body LoginDTO loginDTO);
	*/
	public function login(Request $request) {


	    if ($this->attemptLogin($request)) {
	    	
	    	$user = $this->guard()->user();
	    	
	    	User::where('id', $user->id)->update(['api_token' => str_random(60)]);

	        $data = $this->userDto($user->id);
	        
            return response()->json([
                                    'data' => $data,
                                    'currentNo' => 0,
                                    'startNo' => 0,
                                    'endNo' => 0,
                                    'status' => 200,
                                    'message' => 'Succesfully Logged In']
                                )->setStatusCode(200);

	    }else{

            return response()->json([
                                    'data' => [],
                                    'currentNo' => 0,
                                    'startNo' => 0,
                                    'endNo' => 0,
                                    'status' => 401,
                                    'message' => 'Full authentication is required to access this resource']
                                )->setStatusCode(401);

	    }

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


}