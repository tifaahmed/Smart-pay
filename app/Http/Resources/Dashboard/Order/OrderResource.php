<?php

namespace App\Http\Resources\Dashboard\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Dashboard\Order\UserResource;
use App\Http\Resources\Dashboard\Order\CouponResource;
use App\Http\Resources\Dashboard\Order\AddressResource;

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
            'order_status',
            'payment_card_status',
            'payment_type',
            'discount',
            'delevery_fee',
            'delevery_fee',
            'subtotal',
            'total'
        ];
        $translated_string_fields = [];

        $image_fields  = [];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at','deleted_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'user' => new  UserResource($this->user) ]  ;
        $all += [ 'coupon' => new  CouponResource($this->coupon) ]  ;
        $all += [ 'address' => new  AddressResource($this->address) ]  ;
        

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
