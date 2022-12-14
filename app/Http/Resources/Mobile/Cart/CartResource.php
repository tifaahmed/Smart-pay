<?php

namespace App\Http\Resources\Mobile\Cart;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'quantity'                    =>   $this->quantity ]  ;


        // product info
            $all += [ 'product_id'               =>   $this->product_id ]  ;
            $all += [ 'product_title'               =>   $this->product_title ]  ;
            $all += [ 'product_discount'            =>   $this->product_discount ]  ;
            $all += [ 'product_price'               =>   $this->product_price ]  ;

        // modal get functions
            $all += [ 'product_price_after_offer'   =>   $this->product_price_after_offer ]  ;
            $all += [ 'discount_value'   =>   $this->discount_value ]  ;
            
            $all += [ 'product_price_sub_total'     =>   $this->product_price_sub_total ]  ;
            $all += [ 'discount_value_sub_total'     =>   $this->discount_value_sub_total ]  ;
            
            $all += [ 'product_image'               =>   check_image($this->product_image) ]  ;
                
        // chid relation
            $all += [ 'cart_extras'           =>  CartExtraResource::collection($this->cart_extras) ]  ;
            $all += [ 'store'                 =>  new StoreResource($this->store) ]  ;

        return $all;
    }
}
