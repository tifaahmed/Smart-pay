<?php

namespace App\Http\Resources\Mobile\Extra;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Mobile\Extra\ExtraCategoryResource;
use App\Http\Resources\Mobile\Extra\StoreResource;

class ExtraResource extends JsonResource
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
        $all += [ 'price' =>   $this->price ]  ;
        $all += [ 'status' =>   $this->status ]  ;
        $all += [ 'title' =>   $this->title ]  ;

        $all += [ 'created_at' =>   $this->created_at ]  ;
        $all += [ 'updated_at' =>   $this->updated_at ]  ;


        $all += [ 'extra_category' => new  ExtraCategoryResource($this->extra_category) ]  ;
        $all += [ 'store'          => new  ExtraCategoryResource($this->store) ]  ;
        
        return $all;
    }
}
