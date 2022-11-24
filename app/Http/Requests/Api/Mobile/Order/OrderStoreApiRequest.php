<?php

namespace App\Http\Requests\Api\Mobile\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\CouponUsageLimitRule;
use App\Rules\CouponUserRule;
use App\Rules\CouponWorkingRule;
use App\Rules\CouponDateRule;
use App\Rules\CouponRelatedStoreRule;
use App\Rules\ExtraRelatedProductRule;

use App\Models\Coupon;
use App\Models\ProductItem;
use App\Models\Extra;
use App\Models\Address;
use Auth;

class OrderStoreApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // foreach ($this->order_items as $order_item_key => $order_item) {
        //     if (!$this->order_item['product_id']) {
        //         return false;
        //     }
        // }
        $carts = Auth::user()->carts;
        if ($carts->count() <= 0) {
                return false;
        }
        return true;
        
    }
    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException('the cart is empty.');
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


        $all += [ 'address_id'=>  [ 'required' ,'integer',
        // 'exists:'.Address::class.',id'
        Rule::exists('addresses','id')
        ->where(function ($query) {
            return $query->where('user_id', Auth::user()->id);
        }),
        ] ] ;
        
        // foreach ($this->order_items as $order_item_key => $order_item) {
        //     $all += [ 'order_items.'.$order_item_key.'.product_id' =>  [ 'required' ,'integer','exists:'.ProductItem::class.',id'] ] ;
        //     $all += [ 'order_items.'.$order_item_key.'.quantity' =>  [ 'required' ,'integer','min:1'] ] ;
        //     if (isset($order_item['extra_ids'])) {
        //         foreach ($order_item['extra_ids'] as $key => $value) {                
        //             $all += [ 'order_items.'.$order_item_key.'.extra_ids.'.$key =>  [ 'sometimes' ,'integer','exists:'.Extra::class.',id',
        //                 new ExtraRelatedProductRule($this->order_items[$order_item_key]['product_id']) 
        //             ]  ] ;
        //         }
        //     }
            
        // }
        $all += [ 'coupon_code'=>  [ 'sometimes' ,'integer',
        'exists:'.Coupon::class.',code',
        new CouponUsageLimitRule(),
        new CouponUserRule(),
        new CouponWorkingRule(),
        new CouponDateRule(),
        // new CouponRelatedStoreRule($this->order_items),
    ] ] ;
        return $all;
    }
    public function messages()
    {
        return [
            'address_id.exists' => '"The selected address id is invalid or noy for the login user.',
            
        ];
    }
}