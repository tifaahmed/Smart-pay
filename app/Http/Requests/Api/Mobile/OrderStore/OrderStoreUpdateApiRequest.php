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
            OrderStore::find($this->id)->order()->where('user_id',Auth::user()->id)->first()
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
        $store = OrderStore::find($this->id)->where('store_id',Auth::user()->id)->first();
        $customer =OrderStore::find($this->id)->order()->where('user_id',Auth::user()->id)->first();
        // store    / 'confirmed', 'shipping', 'rejected' ,'accept_to_retrieve','delevered'
        // customer / 'canceled', 'delevered', 'ask_to_retrieve'  

        switch ($store->order_status ) {
            case 'not_confirmed':
                $store_array =['confirmed','rejected','accept_to_retrieve'];
                break;
            case 'confirmed':
                $store_array =['shipping','rejected','accept_to_retrieve'];
                break;
            case 'shipping':
                $store_array =['delevered','rejected','accept_to_retrieve'];
                break;
            case 'rejected':
                $store_array =['accept_to_retrieve'];
                break;    
            case 'ask_to_retrieve':
                $store_array =['accept_to_retrieve','rejected','confirmed'];
                break;      
            default:
            $store_array =['rejected','accept_to_retrieve'];
        }
        switch ($customer->order_status ) {
            case 'canceled':
                $customer_array =['ask_to_retrieve'];
                break;
            case 'delevered':
                $customer_array =['ask_to_retrieve'];
                break;
            default:
            $customer_array =['delevered'];    
        }

         
        if ($store ) {
            $all += [ 'order_status'        =>  [ 'sometimes' ,Rule::in( $store_array) ] ] ;
        }
        else if ($customer ) {
            $all += [ 'order_status'        =>  [ 'sometimes' ,Rule::in($customer_array) ] ] ;
        }
        $all += [ 'retrieve_price'        =>  [ 'sometimes' , 'integer' ] ] ;

        return $all;
    }
    public function messages()
    {
        return [
            
        ];
    }
}