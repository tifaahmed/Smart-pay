<?php

namespace App\Http\Resources\Dashboard\Coupon;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CouponResource extends JsonResource
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


        $string_fields = ['code','type','usage_limit','percent_limit'];
        $translated_string_fields = [
            'title'
        ];

        $image_fields  = [];
        $translated_image_fields  = [];

        $date_fields   = ['start_date','end_date','created_at','updated_at','deleted_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'user' => new  UserResource($this->user) ]  ;
        $all += [ 'store' => new  StoreResource($this->store) ]  ;

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
