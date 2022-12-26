<?php

namespace App\Http\Resources\Mobile\Extra;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ExtraCategoryResource extends JsonResource
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
        $all += [ 'type' =>   $this->type ]  ;
        $all += [ 'title' =>   $this->title ]  ;

        return $all;
    }
}
