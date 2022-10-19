<?php

namespace App\Http\Controllers\ControllerTraits;

use Illuminate\Http\JsonResponse ;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;

trait OrderTrait {



	// * @param  array  $request_order_items
    // @return array of objects (stores data)
    public function get_store_models($request_order_items) 
    {
        return $store_models = Store::whereHas('product_items',function (Builder $query) use($request_order_items) {
            foreach ($request_order_items as $key => $order_item) {
                $key == 0 ? 
                $query->where('id',$order_item['product_id']) 
                : 
                $query->orWhere('id',$order_item['product_id'])
                ;
            }
        })->get();    
    }

    public function get_calculated_discount($coupon_model,$number) {
        $discount_number = 0 ;
        if ($coupon_model && $coupon_model->discount > 0 ) {
            if ($coupon_model->type == 'percent') {
                $discount_number = - (  $number * ($coupon_model->discount/100)  ) + $number ;
                $discount_number > $coupon_model->percent_limit ? $coupon_model->percent_limit : $discount_number;
            
            }else if($coupon_model->type == 'fixed'){
                $discount_number =   $coupon_model->discount ;
            }
            $discount_number;
        }  
    }


}