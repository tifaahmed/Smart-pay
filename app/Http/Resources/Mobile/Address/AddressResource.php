<?php

namespace App\Http\Resources\Mobile\Address;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use  App\Http\Resources\Mobile\Address\CityResource;
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
        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'city' => new  CityResource($this->city) ]  ;

        $all += [ 'address' => $this->address ]  ;
        $all += [ 'house' => $this->house ]  ;
        $all += [ 'street' => $this->street ]  ;
        $all += [ 'note' => $this->note ]  ;
        $all += [ 'type' => $this->type ]  ;
        $all += [ 'latitude' => $this->latitude ]  ;
        $all += [ 'longitude' => $this->longitude ]  ;
 
        return $all;
    }
}
