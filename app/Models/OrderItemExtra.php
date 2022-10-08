<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderItem;// belongsTo
use App\Models\Extra;// belongsTo

class OrderItemExtra extends Model
{
    use HasFactory;
    protected $table = 'order_item_extras';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_item_id', // integer , unsigned
        'extra_id', // integer , nullable , unsigned 

        'extra_name', // string , nullable , 
        'price', // float , default(0) 
    ];

    // belongsTo
        public function order_item(){
            return $this->belongsTo(OrderItem::class,'order_item_id');
        }
        public function extra(){
            return $this->belongsTo(Extra::class,'extra_id');
        }
}

 
