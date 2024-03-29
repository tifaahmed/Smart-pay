<?php

namespace App\Http\Resources\Mobile\ProductCategory;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Mobile\ProductCategory\ProductItemResource;
class ProductCategoryResource extends JsonResource
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

        $product_items = $this->product_items();
        if ($request->filter && isset($request->filter['store_filter']) ) {
            $product_items =  $product_items->RelateStore($request->filter['store_filter']);
        }
        $product_items = $product_items->get();
        $all += [ 'product_items' =>   ProductItemResource::collection($product_items) ]  ;


        return $all;
    }
}
