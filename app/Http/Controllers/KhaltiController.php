<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Khalti;

class KhaltiController extends Controller
{
    // public function __construct(Khalti $khalti)
    // {
    //     $this->khalti = $khalti;
    // }


    //Intial Transaction
    public function transaction(Request $request)
    {
    	$data = [
    		// 'user_id' 	=> $request->user_id,
    		// 'mobile' 	=> $request->mobile,
    		'amount' 	=> $request->amount,
    		'pre_token' => $request->token
    	];

        try 
        {
            //before verification for reference purposes 
            // $khalti = $this->khalti->create($data);

            $khalti = new Khalti;
            $khalti->amount = $request->amount;
            $khalti->pre_token = $request->token;
            $khalti->save();


            $output = $this->verification($khalti);

            if ($output) 
            {
                return response()->json([
                    'success' => '  Your Account is succesfully credited'
                ],200);
            }
            
        } 
        catch (Exception $e) 
        {
            return response()->json([
                    'error' => '  Something went Wrong , Try Again !!'
                ],404);
        }

    }

    // Verification after trannsaction
    public function verification($khalti)
    {
    	$args = http_build_query(array(
                    'token' => $khalti->pre_token,
                    'amount'  => ($khalti->amount * 100)
                ));

        $url = "https://khalti.com/api/payment/verify/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key test_secret_key_206b9b6e5059419aa8451f94404707d5'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $token = json_decode($response, TRUE);
        
        if (isset($token['idx'])&& $status_code == 200) 
        {
            // $khalti = $khalti->update(['status' => 1 , 'verified_token' => $token['idx']]);
            Khalti::update(['status' => 1, 'verified_token' => $token['idx'] ]);
            return true;
            
        }
        return false;
    }
}
