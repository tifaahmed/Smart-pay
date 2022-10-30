<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class OrderStore extends Model
{
    use HasFactory;

    protected $table = 'order_stores';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id', // integer , unsigned , unsigned
        'store_id', // integer , unsigned , will not delete if store deleted

        'store_title', // string , nullable ,
        'store_note',
        
        'coupon_title', // string , nullable ,
        'coupon_code', // string , nullable ,
        'coupon_discount_type',
        'coupon_discount', // float , default(0)  ,order_item_sub_totals - discount
        'delevery_fee', // float , default(0)  ,delevery fee from single stores
        'order_item_sub_totals', // float , default(0)  ,collect sub_total of table order_items
        'sub_total', // float , default(0)  , (order_item_sub_totals + delevery_fee ) - coupon_discount 
    ];
    // hasMany
        public function order_items(){
            return $this->hasMany(OrderItem::class);
        }    
    
}
