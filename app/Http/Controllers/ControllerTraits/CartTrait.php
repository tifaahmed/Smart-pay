<?php

namespace App\Http\Controllers\ControllerTraits;

use Illuminate\Http\JsonResponse ;

use App\Models\ProductItem;
use App\Models\Extra;

use Illuminate\Database\Eloquent\Builder;
use Auth;
trait CartTrait {


    // * @param  int   $product_id
	// * @param  array   $extra_ids
    // @return the repeated object 
    public function getRepeatedProduct($product_id ,$extra_ids )   {
         $carts =  Auth::user()->carts()
        ->where('product_id',$product_id)
        ->get();

        foreach ($carts as $key => $cart) {
            $cart_extra_ids = $cart->cart_extras->pluck('extra_id')->toArray();
            if($cart_extra_ids == $extra_ids) {
                return $cart;
            }
        } 
    }


	// * @param  int   $product_id
	// * @param  int   $quantity
    // @return array 
    public function cart_arr($product_id ,$quantity ) :array {

        $cart_arr = [];

        // user relation
            $cart_arr['user_id'] = Auth::user()->id;

        // product relation
            $cart_arr['product_id'] = $product_id;
            $cart_arr['quantity'] = $quantity;

        // product info
            $product_item = ProductItem::find($product_id);
            $cart_arr['product_title'] = $product_item->title;
            $cart_arr['product_discount'] = $product_item->discount;
            $cart_arr['product_price'] = $product_item->price;

        return $cart_arr;
    }
    public function extra_arr($cart_id,$extra_id) :array  {
        $extra_arr = [];
        // cart relation
            $extra_arr['cart_id'] = $cart_id;

        // extra relation
            $extra_arr['extra_id'] = $extra_id;

        // extra info
            $extra = Extra::find($extra_id);
            $extra_arr['extra_title'] = $extra->title;
            $extra_arr['extra_price'] = $extra->price;

        return $extra_arr;
    }
}