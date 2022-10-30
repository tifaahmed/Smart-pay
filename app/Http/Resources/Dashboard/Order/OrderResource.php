<?php

namespace App\Http\Resources\Dashboard\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Dashboard\Order\UserResource;
use App\Http\Resources\Dashboard\Order\OrderStoreResource;
use App\Http\Resources\Dashboard\Order\OrderInformationResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        $model = $this;
        $lang_array = config('app.lang_array') ;

        $string_fields = [

            'order_status', //string , [ 'not_confirmed','confirmed','shipping','delevered','canceled','ask_to_retrieve'] , default('not_confirmed')
            'payment_card_status' , //string ,  [ 'paid','pindding'] , default('pindding')
            'payment_type' ,  // string , [ 'visa','cash'] , default('cash')
        

            'order_store_sub_totals',// default 0 // collect price of table order_stores


            'order_code',//  random number
            'order_note',
            'site_fee',//  default 0 
            'total',//  default 0 //(order_store_sub_totals + site_fee'
            
        ];
        $translated_string_fields = [];

        $image_fields  = [];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at','deleted_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'order_information' => new  OrderInformationResource($this->order_information) ]  ;
        $all += [ 'order_stores' =>   OrderStoreResource::collection($this->order_stores) ]  ;

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
