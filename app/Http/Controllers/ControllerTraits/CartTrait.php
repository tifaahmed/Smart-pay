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
    public function get_repeated_product($product_id ,$extra_ids )   {
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
    // * @param  object   $cart
    // * @param  array   $cart_extras_ids
	// * @param ( array or null)  $request_extra_ids
    // @return array removed_cart_extras_ids 
    public function get_removed_cart_extras_ids(object $cart, array $cart_extras_ids,array $request_extra_ids=[]) :array  {
        $removed_extras_ids = array_diff($cart_extras_ids,$request_extra_ids);
        return $cart->cart_extras->whereIn('extra_id',$removed_extras_ids)->pluck('id')->toArray();
    }
    // * @param  object   $cart
    // * @param  array   $cart_extras_ids
	// * @param  array   $request_extra_ids
    // @return array added_extras_ids 
    public function get_added_extras_ids(object $cart, array $cart_extras_ids,array $request_extra_ids = []) :array  {
        return $added_extras_ids = array_diff($request_extra_ids,$cart_extras_ids);
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
            $cart_arr['store_id'] = $product_item->store_id;
            $cart_arr['product_title'] = $product_item->title;
            $cart_arr['product_discount'] = $product_item->discount;
            $cart_arr['product_price'] = $product_item->price;

        return $cart_arr;
    }
    public function extra_arr(int $cart_id,int $extra_id) :array  {
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