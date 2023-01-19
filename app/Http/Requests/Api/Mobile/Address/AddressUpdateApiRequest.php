<?php

namespace App\Http\Requests\Api\Mobile\Address;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use  App\Models\User;
use  App\Models\City;
use  App\Models\Address;
use Auth;
class AddressUpdateApiRequest extends FormRequest
{
    public function __construct()
    {
        $this->authorization_message = '';
    }

    public function authorize()
    {
        $model = Address::find($this->id);
        if (!$model) {
            $this->authorization_message = 'id not found';
            return false;
        }
        if ($model->user_id != Auth::user()->id ) {
            $this->authorization_message = 'not your auth data';
            return false;           
        }
        return true;
    }
    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException($this->authorization_message);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
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
