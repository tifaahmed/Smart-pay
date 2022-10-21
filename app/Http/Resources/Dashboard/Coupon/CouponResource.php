<?php

namespace App\Http\Resources\Dashboard\Coupon;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Dashboard\Coupon\UserResource;
use App\Http\Resources\Dashboard\Coupon\StoreResource;
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


        $string_fields = [
            'code',           // string , unique 
           
           'working',          // boolean default('1');
           'type',           // enum   ,  [ 'fixed','percent'] , default('fixed')
           'usage_limit',    // integer , default(1) , // how many will use it
           'usage_counter',   // integer , default(0), //comment(' How many times have it used');
           'discount',// integer , default(1)
           
           // if type is percent percent_limit will work
           //  if type is fixed  percent_limit will be null
           'percent_limit',    // float , nullable , 
           
           'start_date',    // timestamp , default(DB::raw('CURRENT_TIMESTAMP')) , 
   
           // if null coupons will never end
           'end_date',    // timestamp , nullable , 
   
       ];        
       $translated_string_fields = [
        'title'   // string , nullable , [note: "translatable"]
        ];

        $image_fields  = [];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at'];


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
