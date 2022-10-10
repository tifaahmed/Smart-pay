<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;               // belongsTo

use App\Models\OrderItem;          // HasMany
use App\Models\OrderInformations;          // HasMany

class Order extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_status', //string , [ 'not_confirmed','confirmed','shipping','delevered','canceled','ask_to_retrieve'] , default('not_confirmed')
        'payment_card_status' , //string ,  [ 'paid','pindding'] , default('pindding')
        'payment_type' ,  // string , [ 'visa','cash'] , default('cash')
    
        'user_id', // integer , unsigned

        'coupon_title', // string,nullable
        'coupon_code',// string,nullable
        'coupon_store_name',// string,nullable
        
        'delevery_fee_sub_total', // float  , default 0 // delevery price from many stores
        'product_sub_total', // float  , default 0 // collect price of table order_items 
        'extras_sub_total', // float  , default 0 // collect price of table order_item_extras 
        'coupon_discount', // float  , default 0 //discount from single store
        'total', // float  , default 0 //product_sub_total + extras_sub_total + delevery_fee_sub_total) - coupon_discount 
       
        
    ];

    // HasMany
        public function order_item(){
            return $this->HasMany(OrderItem::class);
        }
        public function order_informations(){
            return $this->HasMany(OrderInformations::class);
        }
        
    // belongsTo
        public function user(){
            return $this->belongsTo(User::class,'user_id');
        }
}
 