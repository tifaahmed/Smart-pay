<?php

namespace App\Http\Requests\Api\Dashboard\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {        
        $all=[];

        $all += [ 'first_name'               =>  [ 'required'  ] ]  ;
        $all += [ 'last_name'               =>  [  'sometimes'  ] ]  ;

        $all += [ 'email'               =>  [ 'required_without:phone','unique:users,email,'.$this->id ,'email' ] ]  ;
        $all += [ 'password'               =>  [   'sometimes' ] ]  ;
        $all += [ 'gender'               =>  [   'required' , Rule::in(['girl','boy']) ] ] ;

        $all += [ 'phone'               =>  [  'required_without:email','unique:users,phone,'.$this->id ,'max:15'] ]  ;

        $all += [ 'birthdate'               =>  [   'date'  ] ]  ;
        
        $all += [ 'avatar'               =>  [ 'sometimes','max:50000','mimes:jpg,jpeg,webp,bmp,png' ] ]  ;
        
        $all += [ 'pin_code'               =>  [  'numeric', 'unique:users,pin_code,'.$this->id ] ]  ;
        
        $all += [ 'fcm_token'               =>  [  'sometimes'  ] ]  ;

        $all += [ 'latitude'               =>  [  'sometimes'  ] ]  ;
        $all += [ 'longitude'               =>  [  'sometimes'  ] ]  ;

        $all += [ 'email_verified_at'       =>  ['sometimes','date' ] ]  ;
        $all += [ 'phone_verified_at'       =>  ['sometimes','date' ] ]  ;


 
  
    
        return $all;
    }
}
