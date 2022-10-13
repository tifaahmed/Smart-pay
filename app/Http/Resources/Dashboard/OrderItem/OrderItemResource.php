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
    
        $model = $this;
        $lang_array = config('app.lang_array') ;

        $string_fields = [
            'product_title', // string , nullable , 
            'offer', // 10%,5%,15%,20% product offer
            'quantity', // float , default(1) 
            'sub_total', // float , default(0) ,one product price after offer * product quantity
        
        ];
        $translated_string_fields = [];

        $image_fields  = [];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'order' => new  OrderResource($this->order) ]  ;
        $all += [ 'store' => $this->store ]  ;

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
