<?php

namespace App\Http\Resources\Mobile\Coupon;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Mobile\Coupon\StoreResource;
class CouponResource extends JsonResource
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
        $all += [ 'title' =>   $this->title ]  ;
        $all += [ 'code' =>   $this->code ]  ;
        $all += [ 'working' =>   $this->working ]  ;
        $all += [ 'type' =>   $this->type ]  ;
        $all += [ 'usage_limit' =>   $this->usage_limit ]  ;
        $all += [ 'usage_counter' =>   $this->usage_counter ]  ;
        $all += [ 'discount' =>   $this->discount ]  ;
        $all += [ 'percent_limit' =>   $this->percent_limit ]  ;
        $all += [ 'start_date' =>   $this->start_date ]  ;
        $all += [ 'end_date' =>   $this->end_date ]  ;
        $all += [ 'store_id' => $this->store_id ]  ;

        return $all;
    }
}
