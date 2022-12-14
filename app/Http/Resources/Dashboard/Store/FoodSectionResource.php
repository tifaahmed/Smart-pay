<?php

namespace App\Http\Resources\Dashboard\Store;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FoodSectionResource extends JsonResource
{
    public function toArray($request)
    {
        
        $model = $this;
        $lang_array = config('app.lang_array') ;

        $string_fields = [];
        $translated_string_fields = [
            'title', // text  translatable
            'description', // text ,nullable translatable
        ];

        $image_fields  = ['image'];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at','deleted_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        // $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
