<?php

namespace App\Http\Requests\Api\Mobile\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

 
use App\Models\OrderStore;

use Auth;

class OrderStoreUpdateApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $order_store = Auth::user()->store()->order_store()->find($this->id);

        if (
            OrderStore::find($this->id)->where('store_id',Auth::user()->id)->first() 
            ||
            OrderStore::find($this->id)->order()->where('user_id',Auth::user()->id) 
        ) 
        {
            return  true;
        }else{
            return false;    
        }

            
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
        

        $all=[];
        $all += [ 'store_note'   =>  [ 'sometimes' ] ] ;

        if (OrderStore::find($this->id)->where('store_id',Auth::user()->id)->first() ) {
            $all += [ 'order_status'        =>  [ 'sometimes' ,Rule::in([
                'confirmed', 'shipping', 'rejected' ,'accept_to_retrieve','delevered'
            ]), ] ] ;
        }
        else if (OrderStore::find($this->id)->order()->where('user_id',Auth::user()->id) ) {
            $all += [ 'order_status'        =>  [ 'sometimes' ,Rule::in([
                'canceled', 'ask_to_retrieve' ,'delevered' 
            ]), ] ] ;
        }



        
        return $all;
    }
    public function messages()
    {
        return [
            
        ];
    }
}