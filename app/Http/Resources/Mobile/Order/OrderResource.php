<?php

namespace App\Http\Resources\Mobile\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Mobile\Order\OrderStoreResource;
use App\Http\Resources\Mobile\Order\OrderInformationResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
                
        $all=[];

        $all += [ 'id' =>   $this->id ]  ;

        $all += [ 'payment_type' =>   $this->payment_type ]  ;//  [ 'visa','cash'] , default('cash')

        $all += [ 'payment_card_status' =>   $this->payment_card_status ]  ;// [ 'paid','pindding'] , default('pindding')
        $all += [ 'payment_card_data' =>   $this->payment_card_data ]  ; // text , nullable

        $all += [ 'order_code' =>   $this->order_code ]  ; // string  , unique
        $all += [ 'order_note' =>   $this->order_note ]  ;  // text , nullable // wrote only from admin if needed


        $all += [ 'order_store_price_sub_totals' =>   $this->order_store_price_sub_totals ]  ; // float  , default 0 // collect price of table order_stores
        $all += [ 'order_store_retrieve_sub_totals' =>   $this->order_store_retrieve_sub_totals ]  ; // float  , default 0 // collect retrieve_price of table order_store
       
        $all += [ 'site_fee' =>   $this->site_fee ]  ;//  default 0 
        $all += [ 'total' =>   $this->total ]  ;// float , default 0 //  order_store_price_sub_totals + site_fee
        
        $all += [ 'created_at' =>   $this->created_at ]  ; 

        
        $all += [ 'order_information' =>   new OrderInformationResource ($this->order_information) ]  ; 
        $all += [ 'order_stores' =>   OrderStoreResource::collection($this->order_stores) ]  ;
        
        
        return $all;
    }
}
