<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order; // belongsTo
use App\Models\Store;// belongsTo

use App\Models\OrderItemExtra;// hasMany

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_store_id', // integer , unsigned , cascade

        'product_id', // integer , unsigned ,will not delete if store deleted
        'product_title', // string , nullable , 
        'product_offer', // enum , 0%,10%,5%,15%,20% product offer
        'product_price', // float ,default(1) ,  pure price
        'product_quantity', // integer , default(1) 
        
        'order_item_extra_sub_totals', // float , default(0) ,collect sub_total of table order_item_extras
        'sub_total', // float , default(0) ,(product_price after offer  * quantity ) + order_item_extra_sub_totals
    ];

    // belongsTo
        public function order(){
            return $this->belongsTo(Order::class,'order_id');
        }
        public function store(){
            return $this->belongsTo(Store::class,'store_id');
        }

    // hasMany
        public function order_item_extras(){
            return $this->hasMany(OrderItemExtra::class);
        }    
}
 