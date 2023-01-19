<?php

namespace App\Http\Requests\Api\Mobile\Address;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use  App\Models\User;
use  App\Models\City;

class AddressStoreApiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {        
        $all=[];
        $all += [ 'city_id'   =>  [ 'required' ,'integer','exists:'.City::class.',id'] ] ;
        $all += [ 'address'                 =>  [ 'required'  ] ]  ;
        $all += [ 'department'                 =>  [ 'sometimes'  ] ]  ;

        $all += [ 'house'                 =>  [ 'sometimes'  ] ]  ;
        $all += [ 'street'                 =>  [ 'sometimes'  ] ]  ;
        $all += [ 'note'                 =>  [ 'sometimes'  ] ]  ;
        $all += [ 'floor'                 =>  [ 'sometimes' ,'integer' ] ]  ;

        $all += [ 'type'        =>  [ 'sometimes' ,Rule::in([
            'home', 'work', 'rest' ,'mosque'
        ]), ] ] ;
        $all += [ 'latitude'                 =>  [ 'sometimes'  ] ]  ;
        $all += [ 'longitude'                 =>  [ 'sometimes'  ] ]  ;
        return $all;
    }
}
