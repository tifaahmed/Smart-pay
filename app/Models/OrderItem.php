<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order; // belongsTo
use App\Models\Store;// belongsTo
use App\Models\OrderItem;// belongsTo

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id', // integer , unsigned , cascade
        'store_id', // integer , unsigned ,will not delete if store deleted
        // 'product_id', // integer , nullable , unsigned 

        'product_title', // string , nullable , 
        'offer', // 10%,5%,15%,20% product offer
        'quantity', // float , default(1) 
        'sub_total', // float , default(0) ,one product price after offer * product quantity
    ];


    // belongsTo
        public function order(){
            return $this->belongsTo(Order::class,'order_id');
        }
        public function store(){
            return $this->belongsTo(Store::class,'store_id');
        }
}
 