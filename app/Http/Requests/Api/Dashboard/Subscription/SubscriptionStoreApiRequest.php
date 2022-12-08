<?php

namespace App\Http\Requests\Api\Dashboard\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use  App\Models\Store;

class SubscriptionStoreApiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {        
        $all=[];

        $all += [ 'store_id'   =>  [ 'required' ,'integer','exists:'.Store::class.',id'] ] ;

        $all += [ 'start_date'          =>  [ 'required','date'] ]  ;
        $all += [ 'end_date'             =>  [ 'required','date'] ]  ;

        $all += [ 'month_number'                 =>  [ 'required','integer'  ] ]  ;

        //comment (1-start with pending 2-user can canceled 3- admin  rejected or accepted )
        $all += [ 'subscription_status'        =>  [ 'required' ,Rule::in([
            'pending', 'accepted', 'rejected' ,'canceled'
        ]), ] ] ; // default('pending')
        $all += [ 'payment_type'        =>  [ 'sometimes' ,Rule::in([
            'visa' , 'cash'
        ]), ] ] ; // default('cash')
        $all += [ 'payment_card_status'        =>  [ 'sometimes' ,Rule::in([
            'paid' , 'pindding' , 'rejected' , 'canceled' 
        ]), ] ] ; // nullable

        $all += [ 'payment_card_data'                 =>  [ 'sometimes'  ] ]  ;

        return $all;
    }
}
