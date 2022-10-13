<?php

namespace App\Http\Resources\Dashboard\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Dashboard\Order\UserResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        $model = $this;
        $lang_array = config('app.lang_array') ;
 
         
        $string_fields = [

            'order_status', //string , [ 'not_confirmed','confirmed','shipping','delevered','canceled','ask_to_retrieve'] , default('not_confirmed')
            'payment_card_status' , //string ,  [ 'paid','pindding'] , default('pindding')
            'payment_type' ,  // string , [ 'visa','cash'] , default('cash')
        

            'coupon_title', // string,nullable
            'coupon_code',// string,nullable
            'coupon_store_name',// string,nullable
            

            'delevery_fee_sub_total', // float  , default 0 // delevery price from many stores
            'product_sub_total', // float  , default 0 // collect price of table order_items 
            'extras_sub_total', // float  , default 0 // collect price of table order_item_extras 
            'coupon_discount', // float  , default 0 //discount from single store
            'total', // float  , default 0 //product_sub_total + extras_sub_total + delevery_fee_sub_total) - coupon_discount 
           
        ];
        $translated_string_fields = [];

        $image_fields  = [];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at','deleted_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'user' => new  UserResource($this->user) ]  ;

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
