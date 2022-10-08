<?php

namespace App\Http\Resources\Dashboard\OrderItem;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use  App\Http\Resources\Dashboard\OrderItem\OrderResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // 'order_id', // integer , unsigned
        // 'store_id', // integer , nullable , unsigned 
        // 'product_id', // integer , nullable , unsigned 

        $model = $this;
        $lang_array = config('app.lang_array') ;

        $string_fields = ['product_name','price','quantity'];
        $translated_string_fields = [];

        $image_fields  = ['image'];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'order' => new  OrderResource($this->order) ]  ;
        $all += [ 'store' => $this->store ]  ;
        $all += [ 'product' =>  $this->product ]  ;

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
