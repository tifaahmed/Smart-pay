<?php

namespace App\Http\Requests\Api\Mobile\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;
class StoreStoreApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->store) { // only allaw onw store
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

        $all += [ 'title'                 =>  [ 'required'  ] ]  ;
        $all += [ 'status'     =>  [ 'sometimes' ,Rule::in([
            'pending','accepted','rejected','canceled'
        ]), ] ] ;
        $all += [ 'image'                  =>  [ 'required' ,'max:50000'] ]  ;
        $all += [ 'phone'                 =>  [ 'required'  ] ]  ;
        $all += [ 'latitude'                 =>  [ 'sometimes'  ] ]  ;
        $all += [ 'longitude'                 =>  [ 'sometimes'  ] ]  ;
        $all += [ 'delevery_fee'                 =>  [ 'required','numeric'  ] ]  ;
        foreach ($lang_array as $key => $value) {
            $all += [ 'title.'.$value                 =>  [ 'required'  ] ]  ;
            $all += [ 'description.'.$value                 =>  [ 'required'  ] ]  ;
        }
        return $all;
    }
}
