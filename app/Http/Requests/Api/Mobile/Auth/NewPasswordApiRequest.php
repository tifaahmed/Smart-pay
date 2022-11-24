<?php

namespace App\Http\Requests\Api\Mobile\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class NewPasswordApiRequest extends FormRequest
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


        return [
            'pin_code'     =>  [ 'required', 'exists:'.User::class.',pin_code'] ,

            'password'  =>  [  'required','min:6' , 'confirmed' , 'max:15' , 'different:old_password'],
            'password_confirmation'  =>  [ 'required', 'min:6' , 'max:15' ],
        ];
    }

}
