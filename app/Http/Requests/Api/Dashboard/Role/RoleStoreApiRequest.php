<?php

namespace App\Http\Requests\Api\Dashboard\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use  App\Models\User;
use  App\Models\City;

class RoleStoreApiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {        
        $all=[];
        $all += [ 'name'   =>  [ 'required','unique:roles,name'] ] ;
        $all += [ 'permission_names.*'    =>  [ 'required','exists:permissions,name'] ] ;

        return $all;
    }
}
