<?php

namespace App\Http\Resources\Mobile\Government;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class GovernmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        $all = []  ;

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'name' =>   $this->name ]  ;
        $all += [ 'country' => new  CountryResource($this->country) ]  ;
        $all += [ 'cities' =>  CityResource::collection($this->cities) ]  ;
 
        
        return $all;
    }
}
