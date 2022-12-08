<?php

namespace App\Http\Controllers\ControllerTraits;

use Illuminate\Http\JsonResponse ;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\ProductItem;
use App\Models\Extra;
use App\Models\Address;
use App\Models\SiteSetting;

use Auth;
use Illuminate\Database\Eloquent\Builder;

trait OrderTrait {


    // models of the order 
        public function get_site_fee()   {
            $SiteSetting = new SiteSetting;
            return $site_fee =  $SiteSetting->site_fee;
        }

        // * @param  array of objects  $request_order_items
        // @return array of objects (stores data)
        public function get_store_models($carts)  {
            $store_ids = $carts->pluck('store_id');
            return $store_models = Store::whereIn('id',$store_ids)->get();    
        }
        
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
    // models of the order 

    // order _items calculations
        // * @param  integer    $product_price 
        // * @param  integer    $product_offer   (persent)
        // * @param  integer    $product_quantity 
        // @return  float calculated_cart_product_price  for order_items
        public function get_calculated_cart_product_price($product_price,$product_offer)   {
            return  - (  $product_price * ($product_offer/100)  ) + $product_price ;
        }

        // * @param  single object  $order_item_model 
        //clculate all extras of the single product
        // @return  float (order_item_extra_sub_totals)    // column 
        public function get_calculated_order_item_extra_sub_totals($order_item_model)   {
            return $order_item_model->order_item_extras->sum('sub_total');
        }
        // * @param  integer $product_price_after_offer ex(10% from 100  = 90 )  
        // * @param  integer $cart_product_quantity     ex(6 pieces from single product)  
        // * @param  integer $order_item_extra_sub_totals ex(2 pieces from extras x 10 = 20)  
        //  clculate sub_total of (single product & his extras)*quantity
        // return float (sub_total)                  // column 
        public function get_calculated_order_item_sub_total(
            $product_price_after_offer,
            $cart_product_quantity,
            $order_item_extra_sub_totals
        ) {
            return ($product_price_after_offer + $order_item_extra_sub_totals)* $cart_product_quantity;
        }
    // order _items calculations
  
    // order store calculations

        // * @param  object  $order_store_model 
        //clculate all (order_item_sub_totals)          // column 
        public function get_order_item_sub_totals($order_store_model) {
            return $order_store_model->order_items->sum('sub_total');
        }

        // * @param  integer    $discount 
        // * @param  enum       $type  [percent,fixed]
        // * @param  integer    $percent_limit 
        // * @param  float    $number 
        // @return  float (discount_number)             // column 
        public function get_calculated_discount_number($discount,$type,$percent_limit,$number)   {
            $discount_number = 0 ;
            if ($number && $discount > 0 ) {
                if ($type == 'percent') {
                    $discount_number = - (  $number * ($discount/100)  ) + $number ;
                    $discount_number > $percent_limit ? $percent_limit : $discount_number;
                
                }else if($type == 'fixed'){
                    $discount_number =   $discount ;
                }
            }  
            return  $discount_number;
        }


        // @return  float (sub_total)                   // column 
        public function get_calculated_store_sub_total($discount_number,$order_item_sub_totals,$delevery_fee)  {
            $after_discount  = $order_item_sub_totals - $discount_number ;
            $after_discount = ($after_discount <= 0 ) ? 0 : $after_discount;
            return $sub_total = $after_discount + $delevery_fee  ;
        }



    // order store calculations

    // order  calculations

        // * @param  object    $order_model 
        // @return  float (order_store_sub_totals)          // column 
        public function get_calculated_order_store_sub_totals($order_model)   {
            $site_fee =  $this->get_site_fee();
            return $order_model->order_stores->sum('sub_total') + $site_fee;
        }

        // * @param  object    $order_model 
        // @return float (order_store_retrieve_sub_totals)   // column 
        public function get_calculated_order_store_retrieve_sub_totals($order_model)   {
            return $order_store_retrieve_sub_totals =  $order_model->order_stores->sum('retrieve_price') ;
        }

        // * @param  object    $order_model 
        // @return (total)                                  // column 
        public function get_calculated_order_total($order_model)   {
            $order_store_sub_totals = $this->get_calculated_order_store_sub_totals(
                                            $order_model
                                        );
            $order_store_retrieve_sub_totals = $this->get_calculated_order_store_retrieve_sub_totals(
                                                $order_model
                                            );
            return $total = $order_store_sub_totals - $order_store_retrieve_sub_totals;
        }
        
    
    // order  calculations
    
}