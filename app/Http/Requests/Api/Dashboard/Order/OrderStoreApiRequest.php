<?php

namespace App\Http\Requests\Api\Dashboard\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Address;

class OrderStoreApiRequest extends FormRequest
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
        $all += [ 'order_status'     =>  [ 'sometimes' ,Rule::in([
            'not_confirmed','confirmed','shipping','delevered','canceled','ask_to_retrieve'
        ]), ] ] ; //default('not_confirmed')
        $all += [ 'payment_card_status'     =>  [ 'sometimes' ,Rule::in([
            'paid','pindding'
        ]), ] ] ;//default('pindding')
        $all += [ 'payment_type'     =>  [ 'sometimes' ,Rule::in([
            'visa','cash'
        ]), ] ] ; //default('cash')

        $all += [ 'user_id'=>  [ 'required' ,'integer','exists:'.User::class.',id'] ] ;
        $all += [ 'coupon_id'=>  [ 'sometimes' ,'integer','exists:'.Coupon::class.',id'] ] ;
        $all += [ 'address_id'=>  [ 'required' ,'integer','exists:'.Address::class.',id'] ] ;

        $all += [ 'discount'       =>  [ 'sometimes' ,'numeric'] ]  ;       // default 0
        $all += [ 'delevery_fee'       =>  [ 'sometimes' ,'numeric'] ]  ;   // default 0
        $all += [ 'subtotal'       =>  [ 'sometimes' ,'numeric'] ]  ;       // default 0
        $all += [ 'total'       =>  [ 'sometimes' ,'numeric'] ]  ;          // default 0

        return $all;
    }
}