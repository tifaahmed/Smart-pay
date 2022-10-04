<?php

namespace App\Http\Requests\Api\Dashboard\Extra;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\SpatieUniqueRule;
use App\Models\ExtraCategory;

class ExtraStoreApiRequest extends FormRequest
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

        $all += [ 'price'             =>  [ 'sometimes' ,'numeric'] ]  ;
        $all += [ 'extra_category_id'=>  [ 'required' ,'integer','exists:extra_categories,id'] ] ;


        foreach ($lang_array as $key => $value) {
            $all += [ 'title.'.$value                 =>  [ 'required'  ] ]  ;
        }
        
        return $all;
    }
}