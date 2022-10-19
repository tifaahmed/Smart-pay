<?php

namespace App\Http\Resources\Mobile\Country;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FoodSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'name' =>   $this->name ]  ;
        $all += [ 'description' =>   $this->name ]  ;
        $all += [ 'image' =>   check_image($this->image)]  ;

 
        return $all;
    }
}
