<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;               // belongsTo

use App\Models\OrderStore;          // HasMany
use App\Models\OrderInformation;          // HasMany

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

 
        'order_store_sub_totals', // float  , default 0 // collect price of table order_stores
        
        'site_fee', // float  , default 0  
        'total', // float  , default 0 //(order_store_sub_totals + site_fee'
    
    ];

    // HasMany
        public function order_stores(){
            return $this->HasMany(OrderStore::class);
        }
        public function order_informations(){
            return $this->HasMany(OrderInformation::class,'order_id');
        }
        
    // belongsTo
        public function user(){
            return $this->belongsTo(User::class,'user_id');
        }
}
 