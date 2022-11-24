<?php

namespace App\Http\Controllers\ControllerTraits;

use Illuminate\Http\JsonResponse ;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\ProductItem;
use App\Models\Extra;
use App\Models\Address;
use Auth;
use Illuminate\Database\Eloquent\Builder;

trait OrderTrait {



	// * @param  array of objects  $request_order_items
    // @return array of objects (stores data)
    public function get_store_models($carts)  {
        $store_ids = $carts->pluck('store_id');
        return $store_models = Store::whereIn('id',$store_ids)->get();    
    }
    
    // must return  the model (ProductItem data)
    // public function get_product_item($store_id,$product_id) {
    //     return ProductItem::where('id',$product_id)->where('store_id',$store_id)->first();
    // }
    
    // must return the model (Coupon data)
    public function get_store_coupon($store_id,$coupon_code) {
        return Coupon::where('code',$coupon_code)->where('store_id',$store_id)->first();
    }
    // (Extra data) ralted to product
    public function get_extra($extra_id,$product_item_id) {
        return Extra::where('id',$extra_id)->whereHas('product_items',function (Builder $query) use($product_item_id) {
                $query->where('product_id',$product_item_id) ;
        })->first();
    }

    
    // must return the model (address data)
    public function get_order_address($address_id) {
        return  Address::find($address_id);
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
        }  
        return  $discount_number;
    }


}