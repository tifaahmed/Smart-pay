<?php

namespace App\Http\Requests\Api\Dashboard\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponUpdateApiRequest extends FormRequest
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

        $lang_array = config('app.lang_array') ;
        
        $all=[];
        $all += [ 'code'                =>  [ 'required','unique:coupons,code,'.$this->id ] ]  ;
        $all += [ 'usage_limit'         =>  [ 'sometimes','integer'] ]  ;

        $all += [ 'type'                =>  [ 'sometimes' ,Rule::in(['fixed','percent']), ] ] ;
        $all += [ 'percent_limit'       =>  [ 'required_if:type,percent','numeric',] ]  ;

        $all += [ 'start_date'          =>  [ 'sometimes' ] ]  ;
        $all += [ 'end_date'            =>  [ 'sometimes' ] ]  ;

        $all += [ 'user_id'   =>  [ 'sometimes' ,'integer','exists:users,id'] ] ;
        $all += [ 'store_id'   =>  [ 'required' ,'integer','exists:stores,id'] ] ;

        foreach ($lang_array as $key => $value) {
            $all += [ 'title.'.$value                 =>  [ 'sometimes' ] ]  ;
        }
        
        return $all;
    }
}
