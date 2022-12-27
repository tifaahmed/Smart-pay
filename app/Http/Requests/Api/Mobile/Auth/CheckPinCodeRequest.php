<?php

namespace App\Http\Requests\Api\Mobile\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Rules\OtpChecksRule;
class CheckPinCodeRequest extends FormRequest {
    public function authorize()
       {
           return true;
       }
    public function rules( ) {
        $all     =[]  ;     

                    
        if(is_numeric($this->email_phone)){
            $all += [ 'email_phone'=>  [ 'required' ,'numeric','exists:'.User::class.',phone'] ] ;
            $all += [ 'pin_code'=>  
                [ 
                    'required' , 'integer'  , 'min:6' ,
                    new OtpChecksRule($this->email_phone),
                ] 
            ] ;   
        } else{
            $all += [ 'email_phone'=>  [ 'required' ,'email','exists:'.User::class.',email'] ] ;
            $all += [ 'pin_code'=>  
                [ 
                    'required' , 'integer'  , 'min:6' ,
                    'exists:'.User::class.',pin_code' 
                ] 
            ]; 
        }  

        $all += [ 'fcm_token'=>  [  'sometimes' ,'max:200'] ] ;

        return     $all;    
    }
}
