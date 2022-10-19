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
        'order_item_id', // integer , unsigned , cascade

        'extra_id', // integer , unsigned , will not delete if extra deleted

        'extra_title', // string , nullable ,

        'extra_price', // float , default(0)  ,
        'sub_total', // float , default(0)  ,extra_price
    ];



    // belongsTo
        public function order_item(){
            return $this->belongsTo(OrderItem::class,'order_item_id');
        }
}

 
