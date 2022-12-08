<?php

namespace App\Http\Controllers\Mobile\Auth\ForgetPassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use App\Models\User ;
use App\Http\Requests\Api\Mobile\Auth\NewPasswordApiRequest ;
use Illuminate\Http\Response ;

class NewPasswordController extends Controller
{
    public function new_password(NewPasswordApiRequest $request)
    {
        try {

            $user =  User::where('pin_code',$request->pin_code)->first();

            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();


            return $this -> MakeResponseSuccessful( 
                ['password changed Successfuly'],
                'Successful' ,
                Response::HTTP_OK
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
