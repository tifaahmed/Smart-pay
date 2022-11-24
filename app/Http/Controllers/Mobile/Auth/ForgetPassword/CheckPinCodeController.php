<?php

namespace App\Http\Controllers\Mobile\Auth\ForgetPassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Mobile\Auth\CheckPinCodeRequest ;
use Illuminate\Http\Response ;
use App\Models\User ;

class CheckPinCodeController extends Controller
{


    public function check_pin_code(CheckPinCodeRequest $request){
        $user =  User::where('pin_code',$request->pin_code)->first();
        if ($user) {

            return $this -> MakeResponseSuccessful( 
                ['pin code is correct'],
                'Successful' ,
                Response::HTTP_OK
             ) ;

        }else{
            return $this -> MakeResponseSuccessful( 
                [ 'message' => 'InvalidCredentials' ],  
                'InvalidCredentials' ,
                Response::HTTP_UNAUTHORIZED
            ) ;  
        }
    }
}
