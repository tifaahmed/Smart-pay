<?php

namespace App\Http\Resources\Mobile\Store;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Auth;
class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user_id =  Auth::user() ? Auth::user()->id : $request->user_id;
        // $user_id =  $request->user_id;

        $all=[];
        $all += [ 'id' =>   $this->id ]  ;

        $all += [ 'title' =>   $this->title ]  ;
        $all += [ 'description' =>   $this->description ]  ;
        
        $all += [ 'delevery_fee' =>   $this->delevery_fee ]  ;
        $all += [ 'status' =>   $this->status ]  ;
        
        $all += [ 'image' =>   check_image($this->image)]  ;
        $all += [ 'phone' =>   $this->phone ]  ;

        $all += [ 'latitude' =>   $this->latitude ]  ;
        $all += [ 'longitude' =>   $this->longitude ]  ;
        
        $all += [ 'distance' =>   $this->distance ]  ;
        

        $all += [ 'fav' =>    $this->fav_stores()->RelateUser($user_id)->first() ? 1 : 0 ]  ;
        $all += [ 'rate' =>   $this->rate ]  ;
        

        return $all;
    }
}
