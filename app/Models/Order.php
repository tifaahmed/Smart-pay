<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;               // belongsTo
use App\Models\Coupon;             // belongsTo
use App\Models\Address;            // belongsTo

use App\Models\OrderItem;          // HasMany

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
        'coupon_id', // integer , nullable ,unsigned
        'address_id', // integer  ,unsigned

        'discount', // float  , default 0 //[note: "50 pound"] 
        'delevery_fee', // float  , default 0 // [note: 'delevery price'] 
        'subtotal', // float  , default 0  // [note: "sum products prices [before] "]
        'total', // float  , default 0   // [note: "after discount "]
    ];

    // HasMany
        public function order_item(){
            return $this->HasMany(OrderItem::class);
        }
        
    // belongsTo
        public function user(){
            return $this->belongsTo(User::class,'user_id');
        }
        public function coupon(){
            return $this->belongsTo(Coupon::class,'coupon_id');
        }
        public function address(){
            return $this->belongsTo(Address::class,'address_id');
        }
}
 