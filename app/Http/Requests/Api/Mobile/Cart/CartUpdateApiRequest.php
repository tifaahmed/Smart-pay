<?php

namespace App\Http\Requests\Api\Mobile\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\ExtraRelatedProductRule;

use App\Models\ProductItem;
use App\Models\Extra;
use App\Models\Cart;

use Auth;

class CartUpdateApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $cart = Auth::user()->carts()->find($this->id);
        if (!$cart) {
                return false;
        }
        return true;        
    }
    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException('Not Authoriz.');
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {        
        $product_id = Cart::find($this->id)->product_id;

        $all=[];
        $all += [ 'quantity'   =>  [ 'required' ,'integer'] ] ;
        if ($this->extra_ids) {
            foreach ($this->extra_ids as $key => $value) {                
                $all += [ 'extra_ids.'.$key =>  [ 'required' ,'integer','exists:'.Extra::class.',id',
                    new ExtraRelatedProductRule($product_id) 
                ]  ] ;
            }
        }
        
    
        return $all;
    }
    public function messages()
    {
        return [
            
        ];
    }
}