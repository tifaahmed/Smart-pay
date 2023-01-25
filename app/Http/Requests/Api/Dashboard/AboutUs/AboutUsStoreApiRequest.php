<?php

namespace App\Http\Requests\Api\Dashboard\AboutUs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AboutUsStoreApiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {        
        $all=[];

        $all += [ 'title_one'               =>  [ 'sometimes'  ] ]  ;
        $all += [ 'title_two'               =>  [ 'sometimes'  ] ]  ;
        $all += [ 'subject_one'             =>  [ 'sometimes'  ] ]  ;
        $all += [ 'type'                    =>  [ 'sometimes' ,Rule::in([
            'information', 'terms'
        ]), ] ] ;
    
        return $all;
    }
}
