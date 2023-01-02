<?php

namespace App\Http\Requests\Api\Dashboard\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use  App\Models\User;
use  App\Models\City;
class RoleUpdateApiRequest extends FormRequest
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
        $all += [ 'name'   =>  [ 'required'] ] ;
        $all += [ 'permission_names'    =>  [ 'required','exists:permissions,name'] ] ;

        return $all;
    }
}
