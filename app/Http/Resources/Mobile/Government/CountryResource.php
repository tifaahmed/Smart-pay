<?php

namespace App\Http\Resources\Mobile\Government;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CountryResource extends JsonResource
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
        
        $all += [ 'phone_code' =>   $this->phone_code ]  ;
        $all += [ 'name' =>   $this->name ]  ;
        $all += [ 'image' =>  
        $this->image && Storage::disk('public')->exists( $this->image)
        ? 
        asset(Storage::url( $this->image ) )  
        : 
        null
        ]  ;


        return $all;
    }
}
