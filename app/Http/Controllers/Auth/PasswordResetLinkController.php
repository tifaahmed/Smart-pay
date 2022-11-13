<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Api\Mobile\Auth\ForgetPasswordByEmailApiRequest ;
use Illuminate\Http\Response ;
use Illuminate\Support\Facades\Auth;

class PasswordResetLinkController extends Controller
{

    public function store(ForgetPasswordByEmailApiRequest $request)
    {
        try {
            // return object if phone or email exist
            $user = $this->get_user($request->email_phone);
        
            if ($user->email == $request->email_phone) {
                $status = Password::sendResetLink(
                    // $request->only('email')
                    ['email' => $request->email_phone]
                );
            }

            if ($user->phone == $request->email_phone) {
                $user->sendActivePhoneNotification();
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
}
