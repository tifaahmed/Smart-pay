<?php

namespace App\Http\Resources\Dashboard\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderItemExtraResource extends JsonResource
{
    public function toArray($request)
    {
                
        $all=[];
        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'extra_id' =>   $this->extra_id ]  ;
        $all += [ 'extra_title' =>   $this->extra_title ]  ;
        $all += [ 'extra_price' =>   $this->extra_price ]  ;
 
        $all += [ 'sub_total' =>   $this->sub_total ]  ;
        return $all;

    }
}
