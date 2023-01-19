<?php

namespace App\Http\Resources\Dashboard\Role;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class PermissionResource extends JsonResource
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
            'name',// string
            'page',// string
            'action',// string
        ];
        
        $image_fields  = [];

        $date_fields   = ['created_at','updated_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;

        $all += resource_string($model,$string_fields);
        $all += resource_image($model,$image_fields);

        $all += resource_date($model,$date_fields);
        

        return $all;
    }
}
