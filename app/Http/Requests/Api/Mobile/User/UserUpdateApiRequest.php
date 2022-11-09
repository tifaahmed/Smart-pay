<?php

namespace App\Http\Requests\Api\Mobile\User;

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

        $all += [ 'email'               =>  [ 'sometimes','unique:users,email,'.$this->id ,'email' ] ]  ;
        $all += [ 'password'               =>  [   'sometimes' ] ]  ;
        $all += [ 'gender'               =>  [   'required' , Rule::in(['girl','boy']) ] ] ;

        $all += [ 'phone'               =>  [  'sometimes','unique:users,phone,'.$this->id ,'max:15'] ]  ;

        $all += [ 'birthdate'               =>  [  'sometimes', 'date'  ] ]  ;
        
        $all += [ 'avatar'               =>  [ 'sometimes','max:50000','mimes:jpg,jpeg,webp,bmp,png' ] ]  ;
        
        $all += [ 'pin_code'               =>  [  'numeric', 'unique:users,pin_code,'.$this->id ] ]  ;
        
        $all += [ 'fcm_token'               =>  [  'sometimes'  ] ]  ;

        $all += [ 'latitude'               =>  [  'sometimes'  ] ]  ;
        $all += [ 'longitude'               =>  [  'sometimes'  ] ]  ;


        return $all;
    }
}
