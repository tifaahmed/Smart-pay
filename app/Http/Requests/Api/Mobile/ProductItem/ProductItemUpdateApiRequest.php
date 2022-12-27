<?php

namespace App\Http\Requests\Api\Mobile\ProductItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Extra;
use Auth;

class ProductItemUpdateApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Auth::user()->store->product_items()->find($this->id)) {
            return false;    
        }
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

        $all += [ 'product_category_id'   =>  [ 'sometimes' ,'integer','exists:product_categories,id'] ] ;

        $all += [ 'price'                  =>  [ 'sometimes' ,'numeric'] ]  ;

        $all += [ 'discount'                  =>  [ 'sometimes' ,'numeric','between:0,100.00'] ]  ;

        $store_array =[];
        switch (Auth::user()->store->product_items()->find($this->id)->status ) {
            case 'out_of_stock':
                $store_array =['active','deactivate'];
                break;
            case 'active':
                $store_array =['deactivate','out_of_stock'];
                break;
            case 'deactivate':
                $store_array =['active','out_of_stock'];
                break;
            default:
            $store_array =[];
        }
        $all += [ 'status'     =>  [ 'sometimes' ,Rule::in($store_array), ] ] ;
        $all += [ 'product_extra_ids' =>  [ 'sometimes' ,'array','exists:'.Extra::class.',id'] ] ;

        foreach ($lang_array as $key => $value) {
            $all += [ 'title.'.$value                 =>  [ 'sometimes'  ] ]  ;
            $all += [ 'description.'.$value                 =>  [ 'sometimes'  ] ]  ;
        }
        return $all;
    }
}
