<?php

namespace App\Http\Requests\Api\Dashboard\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use  App\Models\User;
use  App\Models\City;
class SubscriptionUpdateApiRequest extends FormRequest
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

        $all += [ 'store_id'   =>  [ 'required' ,'integer','exists:'.User::class.',id'] ] ;

        $all += [ 'start_date'          =>  [ 'required'] ]  ;
        $all += [ 'end_date'             =>  [ 'required'] ]  ;

        $all += [ 'month_number'                 =>  [ 'integer'  ] ]  ;

        //comment (1-start with pending 2-user can canceled 3- admin  rejected or accepted )
        $all += [ 'subscription_status'        =>  [ 'sometimes' ,Rule::in([
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
