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

        $all += [ 'status' =>   $this->status ]  ;

        $all += [ 'image' =>   check_image($this->image)]  ;

        $all += [ 'title' =>   $this->title ]  ;
        $all += [ 'description' =>   $this->description ]  ;
        $all += [ 'phone' =>   $this->phone ]  ;
        
        $all += [ 'rate' =>   $this->rate ]  ;
        $all += [ 'delevery_fee' =>   $this->delevery_fee ]  ;
        
        $all += [ 'address' =>   $this->address ]  ;
        $all += [ 'streat' =>   $this->streat ]  ;
        $all += [ 'building' =>   $this->building ]  ;

        $all += [ 'city_id' =>   $this->city_id ]  ;
        $all += [ 'city_name' =>   $this->city_name ]  ;
        
        $all += [ 'latitude' =>   $this->latitude ]  ;
        $all += [ 'longitude' =>   $this->longitude ]  ;
        
        // append
        $all += [ 'distance' =>   $this->distance ]  ;
        

        $all += [ 'fav' =>    $this->fav_stores()->RelateUser($user_id)->first() ? 1 : 0 ]  ;
        

        return $all;
    }
}
