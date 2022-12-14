<?php

namespace App\Http\Resources\Dashboard\ProductItem;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use App\Http\Resources\Dashboard\ProductItem\StoreResource;
use App\Http\Resources\Dashboard\ProductItem\ProductCategoryResource;
use App\Http\Resources\Dashboard\ProductItem\ExtraResource;

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
        
        $model = $this;
        $lang_array = config('app.lang_array') ;

        $string_fields = ['status','price','discount'];
        $translated_string_fields = [
            'title','description', 

        ];

        $image_fields  = ['image'];
        // $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at','deleted_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'store' =>   new StoreResource ($this->store) ]  ;
        $all += [ 'product_category' => new  ProductCategoryResource($this->product_category) ]  ;
        $all += [ 'product_extras' => ExtraResource::collection($this->product_extras) ]  ;

        $all += resource_translated_string($model,$lang_array,$translated_string_fields);
        // $all += resource_translated_image($model,$lang_array,$translated_image_fields);

        $all += resource_image($model,$image_fields);
        $all += resource_string($model,$string_fields);

        $all += resource_date($model,$date_fields);
        
        return $all;
    }
}
