<?php

namespace App\Http\Resources\Mobile\OrderStore;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Mobile\OrderStore\OrderItemResource;
use App\Http\Resources\Mobile\OrderStore\OrderResource;

class OrderStoreResource extends JsonResource
{
    public function toArray($request)
    {
                
        $all=[];
        $all += [ 'id' =>   $this->id ]  ;
        
        $all += [ 'order_status' =>   $this->order_status ]  ;

        $all += [ 'store_id' =>   $this->store_id ]  ;
        $all += [ 'store_title' =>   $this->store_title ]  ;
        $all += [ 'store_note' =>   $this->store_note ]  ;
        
        $all += [ 'coupon_title' =>   $this->coupon_title ]  ;
        $all += [ 'coupon_code' =>   $this->coupon_code ]  ;
        $all += [ 'coupon_discount_type' =>   $this->coupon_discount_type ]  ;
        $all += [ 'coupon_discount' =>   $this->coupon_discount ]  ;

        $all += [ 'retrieve_price' =>   $this->retrieve_price ]  ;
        $all += [ 'delevery_fee' =>   $this->delevery_fee ]  ;
        $all += [ 'order_item_sub_totals' =>   $this->order_item_sub_totals ]  ;
        $all += [ 'sub_total' =>   $this->sub_total ]  ;

        $all += [ 'order_items' =>   OrderItemResource::collection($this->order_items) ]  ;
        $all += [ 'order' =>   new OrderResource ($this->order) ]  ;
        return $all;

    }
}
