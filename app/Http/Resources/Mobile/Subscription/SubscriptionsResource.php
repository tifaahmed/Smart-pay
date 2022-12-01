<?php

namespace App\Http\Resources\Mobile\Subscription;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Auth;
class SubscriptionsResource extends JsonResource
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

        $all += [ 'start_date' =>   $this->start_date ]  ;
        $all += [ 'end_date' =>   $this->end_date ]  ;


        $all += [ 'month_number' =>   $this->month_number ]  ;

        
        $all += [ 'subscription_status' =>   $this->subscription_status ]  ;
        
        $all += [ 'payment_type' =>   $this->payment_type ]  ;
        
        $all += [ 'payment_card_status' =>   $this->payment_card_status ]  ;
        $all += [ 'payment_card_data' =>   $this->payment_card_data ]  ;
       
        return $all;
    }
}
