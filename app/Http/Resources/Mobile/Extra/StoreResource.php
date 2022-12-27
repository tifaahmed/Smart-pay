<?php

namespace App\Http\Resources\Mobile\Extra;

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
        $all += [ 'image' =>   check_image($this->image)]  ;
        return $all;
    }
}
