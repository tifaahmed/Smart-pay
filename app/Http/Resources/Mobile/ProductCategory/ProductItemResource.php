<?php

namespace App\Http\Resources\Mobile\ProductCategory;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductItemResource extends JsonResource
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
        $all += [ 'status' =>   $this->status ]  ;
        $all += [ 'price' =>   $this->price ]  ;
        $all += [ 'discount' =>   $this->discount ]  ;
        $all += [ 'description' =>   $this->description ]  ;
        $all += [ 'image' =>   check_image($this->image)]  ;

        $all += [ 'fav' =>    $this->fav_products()->RelateUser($user_id)->first() ? 1 : 0 ]  ;
        $all += [ 'rate' =>   $this->rate ]  ;


        return $all;
    }
}
