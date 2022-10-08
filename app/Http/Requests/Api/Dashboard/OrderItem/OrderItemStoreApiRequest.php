<?php

namespace App\Http\Requests\Api\Dashboard\OrderItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Order;
use App\Models\Store;
use App\Models\OrderItem;

class OrderItemStoreApiRequest extends FormRequest
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
 
        $all += [ 'order_id'=>  [ 'required' ,'integer','exists:'.Order::class.',id'] ] ;
        $all += [ 'store_id'=>  [ 'sometimes' ,'integer','exists:'.Store::class.',id'] ] ;
        $all += [ 'product_id'=>  [ 'required' ,'integer','exists:'.OrderItem::class.',id'] ] ;

        $all += [ 'product_name'       =>  [ 'sometimes'  ] ]  ;       // default 0
        $all += [ 'price'       =>  [ 'sometimes' ,'numeric'] ]  ;   // default 0
        $all += [ 'quantity'       =>  [ 'sometimes' ,'numeric'] ]  ;       // default 0

        return $all;
    }
}