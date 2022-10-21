<?php

namespace App\Http\Requests\Api\Mobile\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Coupon;
use App\Models\ProductItem;
use App\Models\Extra;
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
        $all += [ 'payment_type'     =>  [ 'sometimes' ,Rule::in([
            'visa','cash'
        ]), ] ] ; //default('cash')
       
        $all += [ 'coupon_code'=>  [ 'sometimes' ,'integer','exists:'.Coupon::class.',code'] ] ;
        $all += [ 'address_id'=>  [ 'required' ,'integer','exists:'.Address::class.',id'] ] ;
        
        foreach ($this->order_items as $key => $value) {
            $all += [ 'order_items.'.$key.'.product_id' =>  [ 'required' ,'integer','exists:'.ProductItem::class.',id'] ] ;
            $all += [ 'order_items.'.$key.'.quantity' =>  [ 'required' ,'integer','min:1'] ] ;
            $all += [ 'order_items.'.$key.'.extra_ids' =>  [ 'sometimes' ,'array','exists:'.Extra::class.',id'] ] ;
        }
        
        return $all;
    }
}