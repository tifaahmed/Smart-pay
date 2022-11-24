<?php

namespace App\Http\Requests\Api\Mobile\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\ExtraRelatedProductRule;

use App\Models\ProductItem;
use App\Models\Extra;

use Auth;

class CartStoreApiRequest extends FormRequest
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
        
        $all += [ 'product_id' =>  [ 'required' ,'integer','exists:'.ProductItem::class.',id'] ] ;
        $all += [ 'quantity'   =>  [ 'required' ,'integer','min:1'] ] ;
        if ($this->extra_ids) {
            foreach ($this->extra_ids as $key => $value) {                
                $all += [ 'extra_ids.'.$key =>  [ 'required' ,'integer','exists:'.Extra::class.',id',
                    new ExtraRelatedProductRule($this->product_id) 
                ]  ] ;
            }
        }
        
        
    
        return $all;
    }
    public function messages()
    {
        return [
            'address_id.exists' => '"The selected address id is invalid or noy for the login user.',
            
        ];
    }
}