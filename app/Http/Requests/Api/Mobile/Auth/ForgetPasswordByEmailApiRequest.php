<?php

namespace App\Http\Requests\Api\Mobile\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class ForgetPasswordByEmailApiRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $all = [];
        if(is_numeric($this->email_phone)){
            $all += [ 'email_phone'=>  [ 'required' ,'numeric','exists:'.User::class.',phone'] ] ;
        } else{
            $all += [ 'email_phone'=>  [ 'required' ,'string','email','exists:'.User::class.',email'] ] ;
        }
        return $all;
    }
}
