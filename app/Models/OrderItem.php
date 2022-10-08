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
        'order_id', // integer , unsigned
        'store_id', // integer , nullable , unsigned 
        'product_id', // integer , nullable , unsigned 

        'product_name', // string , nullable , 
        'price', // float , default(0) 
        'quantity', // float , default(0) 
    ];


    // belongsTo
        public function order(){
            return $this->belongsTo(Order::class,'order_id');
        }
        public function store(){
            return $this->belongsTo(Store::class,'store_id');
        }
        public function product(){
            return $this->belongsTo(OrderItem::class,'product_id');
        }
}
 