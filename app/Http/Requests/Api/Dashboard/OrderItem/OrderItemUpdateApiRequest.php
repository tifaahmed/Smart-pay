<?php

namespace App\Http\Requests\Api\Dashboard\OrderItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Order;
use App\Models\Store;
use App\Models\Product;

class OrderItemUpdateApiRequest extends FormRequest
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

        $all += [ 'product_title'       =>  [ 'sometimes'  ] ]  ;   
        $all += [ 'offer'       =>  [ 'sometimes' ,'numeric'] ]  ;  // 0%, 10%,5%,15%,20% product offer
        $all += [ 'quantity'       =>  [ 'sometimes' ,'numeric'] ]  ;       // default 1
        $all += [ 'sub_total'       =>  [ 'sometimes' ,'numeric'] ]  ;       // default 0

        return $all;
    }
}
