<?php

namespace App\Http\Requests\Api\Dashboard\AboutUs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AboutUsUpdateApiRequest extends FormRequest
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
