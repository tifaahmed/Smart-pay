<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth ;

use App\Models\User;               // belongsTo

use App\Models\OrderStore;          // HasMany
use App\Models\OrderInformation;    // HasOne

class Order extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', // integer , unsigned // will not delete if user deleted

        'payment_type' ,  // string , [ 'visa','cash'] , default('cash')
        
        'payment_card_status' , //string ,  [ 'paid','pending'] , nullable
        'payment_card_data' , // text , nullable

        'order_code', // string  , unique
        'order_note', // text , nullable // wrote only from admin if needed
        
        //1- user paied with card and shop reject
        //2- user paied with cash or card and ask to ask_to_retrieve from the store_id
        //create cuopon automatic to the user_id with store_id
        'order_store_retrieve_sub_totals', // float  , default 0 // collect retrieve_price of table order_store
        'order_store_price_sub_totals', // float  , default 0 // collect price of table order_stores

        'site_fee', // float  , default 0  
        'total' // float , default 0 // order_store_price_sub_totals + site_fee

    ];


    //scope
        public function scopeRelateAuthUser($query){
            return $query->where('user_id',Auth::user()->id);
        }

    // HasMany
        public function order_stores(){
            return $this->HasMany(OrderStore::class);
        }
    // belongsTo
        public function user(){
            return $this->belongsTo(User::class,'user_id');
        }
    // HasOne
        public function order_information(){
            return $this->HasOne(OrderInformation::class,'order_id');
        }    
}
 