<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder;

class CouponRelatedStoreRule implements Rule
{
    public $order_items;

    public function __construct($order_items)
    {
        $this->order_items = $order_items;
    }

    public function passes($attribute, $value)
    {
        $order_items = $this->order_items;
        $coupon = Coupon::where('code',$value)->whereHas('store',function (Builder $query) use($order_items){
            $query->whereHas('product_items',function (Builder $query) use($order_items) {
                foreach ($order_items as $key => $order_item) {
                    $key == 0 ? 
                    $query->where('id',$order_item['product_id']) 
                    : 
                    $query->orWhere('id',$order_item['product_id'])
                    ;
                }
            });    
        })->first();
        return $coupon ? 1 : 0 ;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'not related to any stores.';
    }
}
