<?php

namespace App\Http\Requests\Api\Mobile\ProductItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductItemFavApiRequest extends FormRequest
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

        $all += [ 'product_id'   =>  [ 'required' ,'integer','exists:product_items,id'] ] ;

        return $all;
    }
}
