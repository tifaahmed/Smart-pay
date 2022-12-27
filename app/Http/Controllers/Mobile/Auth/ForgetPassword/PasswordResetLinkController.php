<?php

namespace App\Http\Controllers\Mobile\Auth\ForgetPassword;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Api\Mobile\Auth\ForgetPasswordByEmailApiRequest ;
use Illuminate\Http\Response ;

class PasswordResetLinkController extends Controller
{

    public function store(ForgetPasswordByEmailApiRequest $request)
    {
        try {
            // return user object if phone or email exist
            $user = $this->get_user($request->email_phone);
        
            if ($user->email == $request->email_phone) {
                $status = Password::sendResetLink([
                    'email' => $request->email_phone
                ]);
            }

            if ($user->phone == $request->email_phone) {
                $this->OtpSend($request->email_phone);
            }

            return $this -> MakeResponseSuccessful( 
                ['pin code sent Successfully'],
                'Successful' ,
                Response::HTTP_OK
            ) ;
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }    
    }


    public function check_pin_code(CheckPinCodeRequest $request){
        $user =  User::where('pin_code',$request->pin_code)->first();
        if ($user) {
            if ($user->email) {
                $user->update([ 'email_verified_at' => date("Y-m-d H:i:s") ]);
            }
            if($user->phone){
                $user->update([ 'phone_verified_at' => date("Y-m-d H:i:s") ]);
            }
            return $this ->loginUser($user);
        }else{
            return $this -> MakeResponseSuccessful( 
                [ 'message' => 'InvalidCredentials' ],  
                'InvalidCredentials' ,
                Response::HTTP_UNAUTHORIZED
            ) ;  
        }
    }
}
