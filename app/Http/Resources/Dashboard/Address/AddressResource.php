<?php

namespace App\Http\Resources\Dashboard\Address;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use  App\Http\Resources\Dashboard\Address\UserResource;
use  App\Http\Resources\Dashboard\Address\CityResource;
class AddressResource extends JsonResource
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
            'city_name',
            'address',
            'department',
            'house',
            'street',
            'note',
            'type',
            'floor',
            'latitude',
            'longitude',
        ];
        $translated_string_fields = [];

        $image_fields  = [];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'user' => new  UserResource($this->user) ]  ;
        $all += [ 'city' => new  CityResource($this->city) ]  ;

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
