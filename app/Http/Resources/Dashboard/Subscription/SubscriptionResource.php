<?php

namespace App\Http\Resources\Dashboard\Subscription;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SubscriptionResource extends JsonResource
{
    public function toArray($request)
    {
        
        $model = $this;
        $lang_array = lang_array() ;


        $string_fields = [
            'start_date', //  date   
            'end_date', //  date   
    
            'month_number', //  integer  / number of months
    
            //comment (1-start with pending 2-user can canceled 3- admin  rejected or accepted )
            'subscription_status' , //string ,  [ 'pending', 'accepted', 'rejected' ,'canceled'] , default('pending')
    
            'payment_type', //  enum  / visa , cash / default('cash');
    
            'payment_card_status', //  enum  / paid , pindding , rejected , canceled / nullable ;
            'payment_card_data', //  text  nullable ;
        ];
        $translated_string_fields = [];

        $image_fields  = [];
        $translated_image_fields  = [];

        $date_fields   = ['created_at','updated_at'];


        $all=[];

        $all += [ 'id' =>   $this->id ]  ;
        
        // relations 
            $all += [ 'store' =>   $this->store ]  ;// integer , unsigned ,comment( on Delete cascade )
        
        //  Resources/Helpers functions 
            $all += resource_translated_string($model,$lang_array,$translated_string_fields);
            $all += resource_translated_image($model,$lang_array,$translated_image_fields);

            $all += resource_image($model,$image_fields);
            $all += resource_string($model,$string_fields);

            $all += resource_date($model,$date_fields);
            
        return $all;
    }
}
