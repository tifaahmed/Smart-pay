<?php

namespace App\Http\Requests\Api\Dashboard\ProductItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Extra;

class ProductItemUpdateApiRequest extends FormRequest
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

        $all += [ 'image'                  =>  [ 'sometimes' ,'max:50000'] ]  ;

        $all += [ 'store_id'   =>  [ 'required' ,'integer','exists:stores,id'] ] ;
        $all += [ 'product_category_id'   =>  [ 'required' ,'integer','exists:product_categories,id'] ] ;

        $all += [ 'price'                  =>  [ 'sometimes' ,'numeric'] ]  ;
        $all += [ 'rate'                  =>  [ 'sometimes' ,'between:1,5'] ]  ;

        $all += [ 'discount'                  =>  [ 'sometimes' ,'numeric','between:0,100.00'] ]  ;

        $all += [ 'status'     =>  [ 'sometimes' ,Rule::in([
            'request_as_new','request_as_edit','active','deactivate','out_of_stock'
        ]), ] ] ;
        $all += [ 'product_extra_ids' =>  [ 'sometimes' ,'array','exists:'.Extra::class.',id'] ] ;

        foreach ($lang_array as $key => $value) {
            $all += [ 'title.'.$value                 =>  [ 'required'  ] ]  ;
            $all += [ 'description.'.$value                 =>  [ 'required'  ] ]  ;
        }
        return $all;
    }
}
