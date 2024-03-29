<?php

namespace App\Http\Resources\Dashboard\AboutUs;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AboutUsResource extends JsonResource
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
            'type', // enum => 'information', 'terms'/ default =>'information'
        ];
        $translated_string_fields = [
            'title_one',  // string  ,nullable
            'title_two',  // string  ,nullable
            'subject_one',  // text  
        ];

        $image_fields  = [];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        // $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        // $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
