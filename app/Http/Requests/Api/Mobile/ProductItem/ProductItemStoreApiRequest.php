<?php

namespace App\Http\Requests\Api\Mobile\ProductItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Extra;

class ProductItemStoreApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $lang_array = config('app.lang_array') ;
        
        $all=[];

        $all += [ 'image'                  =>  [ 'required' ,'max:50000'] ]  ;

        $all += [ 'product_category_id'   =>  [ 'required' ,'integer','exists:product_categories,id'] ] ;

        $all += [ 'price'                  =>  [ 'sometimes' ,'numeric'] ]  ;

        $all += [ 'discount'                  =>  [ 'sometimes' ,'numeric','between:0,100.00'] ]  ;
        

        $all += [ 'product_extra_ids' =>  [ 'sometimes' ,'array','exists:'.Extra::class.',id'] ] ;

        foreach ($lang_array as $key => $value) {
            $all += [ 'title.'.$value                 =>  [ 'required'  ] ]  ;
            $all += [ 'description.'.$value                 =>  [ 'required'  ] ]  ;
        }
        return $all;
    }
}
