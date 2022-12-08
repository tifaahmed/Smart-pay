<?php

namespace App\Http\Resources\Mobile\OrderStore;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class OrderInformationResource extends JsonResource
{
    public function toArray($request)
    {
                
        $all=[];
        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'order_id' =>   $this->order_id ]  ;

        $all += [ 'user_full_name' =>   $this->user_full_name ]  ;
        $all += [ 'phone' =>   $this->phone ]  ;
        $all += [ 'email' =>   $this->email ]  ;

        $all += [ 'address' =>   $this->address ]  ;
        $all += [ 'department' =>   $this->department ]  ;
        $all += [ 'house' =>   $this->house ]  ;
        $all += [ 'street' =>   $this->street ]  ;
        $all += [ 'note' =>   $this->note ]  ;
        $all += [ 'type' =>   $this->type ]  ;

        $all += [ 'city_id' =>   $this->city_id ]  ;
        $all += [ 'city_name' =>   $this->city_name ]  ;

        $all += [ 'latitude' =>   $this->latitude ]  ;
        $all += [ 'longitude' =>   $this->longitude ]  ;

 
        return $all;

    }
}
