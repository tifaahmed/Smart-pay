<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Mobile\Auth\UpdatePasswordRequest ;

use Illuminate\Http\Request;
use Illuminate\Http\Response ;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{


    public function update_password(UpdatePasswordRequest $request)
    {
        try {

            Auth::user()->update(['password'=>Hash::make($request->password)]);
            return $this -> MakeResponseSuccessful( 
                ['message'=> 'Password reset successfully'],
                'Successful' ,
                Response::HTTP_OK
            ) ;


            return $this -> MakeResponseSuccessful( 
                [ 'message' => 'InvalidCredentials' ],  
                'InvalidCredentials' ,
                Response::HTTP_UNAUTHORIZED
            ) ;          
        } catch (\Exception $e) {
            return $this -> MakeResponseSuccessful( 
                [ 'message' => 'InvalidCredentials' ],  
                'InvalidCredentials' ,
                Response::HTTP_UNAUTHORIZED
            ) ;  
        }  
    }
    
 
}
