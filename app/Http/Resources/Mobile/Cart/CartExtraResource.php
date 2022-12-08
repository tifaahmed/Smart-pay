<?php

namespace App\Http\Resources\Mobile\Cart;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CartExtraResource  extends JsonResource
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
        $all += [ 'extra_id' =>   $this->extra_id ]  ;
        $all += [ 'extra_title' =>   $this->extra_title ]  ;
        $all += [ 'extra_price' =>   $this->extra_price ]  ;
    
        return $all;
    }
}
