<?php

namespace App\Http\Resources\Mobile\FoodSection;

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
        $all += [ 'title' =>   $this->title ]  ;
        $all += [ 'description' =>   $this->description ]  ;
        $all += [ 'image' =>   check_image($this->image)]  ;

 
        return $all;
    }
}
