<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store;              // belongsTo

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'store_id', // integer , unsigned ,comment( on Delete cascade )

        'start_date', //  date   
        'end_date', //  date   

        'month_number', //  integer  / number of months

        //comment (1-start with pending 2-user can canceled 3- admin  rejected or accepted )
        'subscription_status' , //string ,  [ 'pending', 'accepted', 'rejected' ,'canceled'] , default('pending')

        'payment_type', //  enum  / visa , cash / default('cash');

        'payment_card_status', //  enum  / paid , pindding , rejected , canceled / nullable ;
        'payment_card_data', //  text  nullable ;
    ];


    // belongsTo
        public function store(){
            return $this->belongsTo(Store::class,'store_id');
        }
 

}
