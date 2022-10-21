<?php

namespace App\Http\Resources\Mobile\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Mobile\Order\OrderStoreResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
                
        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'order_status' =>   $this->order_status ]  ; // [ 'not_confirmed','confirmed','shipping','delevered','canceled','ask_to_retrieve'] , default('not_confirmed')
        $all += [ 'payment_card_status' =>   $this->payment_card_status ]  ;// [ 'paid','pindding'] , default('pindding')
        $all += [ 'payment_type' =>   $this->payment_type ]  ;//  [ 'visa','cash'] , default('cash')

        $all += [ 'order_store_sub_totals' =>   $this->payment_type ]  ;// default 0 // collect price of table order_stores

        $all += [ 'site_fee' =>   $this->site_fee ]  ;//  default 0 
        $all += [ 'total' =>   $this->total ]  ;//  default 0 //(order_store_sub_totals + site_fee'
        $all += [ 'created_at' =>   $this->created_at ]  ; 

        $all += [ 'order_stores' =>   OrderStoreResource::collection($this->order_stores) ]  ;
        return $all;
    }
}
