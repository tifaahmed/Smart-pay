<?php

namespace App\Http\Requests\Api\Dashboard\FoodSection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FoodSectionStoreApiRequest extends FormRequest
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

        $all += [ 'image'             =>  [ 'required' ,'max:50000','mimes:jpg,jpeg,webp,bmp,png'] ]  ;

        foreach ($lang_array as $key => $value) {
            $all += [ 'title.'.$value                 =>  [ 'required'  ] ]  ;
            $all += [ 'description.'.$value                 =>  [ 'sometimes'  ] ]  ;
        }
        
        return $all;
    }
}