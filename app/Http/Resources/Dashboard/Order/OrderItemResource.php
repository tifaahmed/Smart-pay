<?php

namespace App\Http\Resources\Dashboard\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Dashboard\Order\OrderItemExtraResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
                
        $all=[];
        $all += [ 'id' =>   $this->id ]  ;
 
        $all += [ 'product_id' =>   $this->product_id ]  ;
        $all += [ 'product_title' =>   $this->product_title ]  ;
        $all += [ 'product_offer' =>   $this->product_offer ]  ;
        $all += [ 'product_price' =>   $this->product_price ]  ;

        $all += [ 'quantity' =>   $this->quantity ]  ;

        $all += [ 'order_item_extra_sub_totals' =>   $this->order_item_extra_sub_totals ]  ;

        $all += [ 'sub_total' =>   $this->sub_total ]  ;

 
        $all += [ 'order_item_extras' =>   OrderItemExtraResource::collection($this->order_item_extras) ]  ;
        return $all;

    }
}
