<?php

namespace App\Http\Resources\Mobile\ExtraCategory;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Mobile\ExtraCategory\ExtraResource;
use Illuminate\Database\Eloquent\Builder;

class ExtraCategoryResource extends JsonResource
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
        $all += [ 'type' =>   $this->type ]  ;
        $all += [ 'title' =>   $this->title ]  ;


        $extras = $this->extras()->ProductFilter($request->filter)->get();

        $all += [ 'extras' =>  ExtraResource::collection($extras) ]  ;

        return $all;
    }
}
