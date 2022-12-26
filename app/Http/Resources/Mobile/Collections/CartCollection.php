<?php

namespace App\Http\Resources\Mobile\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Http\Resources\Mobile\Cart\CartResource as ModelResource;

class CartCollection  extends ResourceCollection{

    public function toArray( $request ) {
         
        return $this -> collection -> map( fn( $model ) => new ModelResource ( $model ) );
    }
    
    public function with( $request ) {
        $temp_arr = [];
        $cart_product_price_sub_total = $this -> collection->sum('product_price_sub_total');
        $cart_discount_value_sub_total = $this -> collection->sum('discount_value_sub_total');
        $cart_delevery_fee = 0;
            foreach ($this -> collection as $key => $model) {
                $store_id       = $model->store->id;
                $delevery_fee   = $model->store->delevery_fee;

                if (   !in_array($store_id, $temp_arr)   ) {
                    array_push($temp_arr,$store_id);
                    $cart_delevery_fee += $delevery_fee;
                }
            } 
        $cart_total =  $cart_product_price_sub_total + $cart_delevery_fee;
        return [
            'cart_product_price_sub_total' => $cart_product_price_sub_total ,
            'cart_discount_value_sub_total' => $cart_discount_value_sub_total ,
            'cart_delevery_fee' => $cart_delevery_fee ,
            'cart_total' => $cart_total ,

            'message' => 'Successful.' ,
            'status'   => true          ,
            'code'   => 200          ,
        ];
    }
}
