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

    public function forget_password(UpdatePasswordRequest $request)
    {
        // return object if phone or email exist
        $user = $this->get_user($request->email_phone);
    
        if (condition) {
            # code...
        }
        $status = Password::sendResetLink(
            $request->only('email')
        );
        
        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }
        return $this -> MakeResponseSuccessful( 
            ['pin code sent Successfully'],
            'Successful' ,
            Response::HTTP_OK
         ) ;
    }
    public function store(Request $request)
    {
   
    }
}
