<?php

namespace App\Http\Requests\Api\Mobile\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRateApiRequest extends FormRequest
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

        $all += [ 'store_id'   =>  [ 'required' ,'integer','exists:stores,id'] ] ;
        $all += [ 'rate'         =>  [ 'required' ,'between:1,5'] ]  ;

        return $all;
    }
}
