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
        'order_id', // integer , unsigned , unsigned // will be deleted if order deleted
        
        //  'not_confirmed','confirmed','shipping','delevered', 'canceled','rejected','ask_to_retrieve','accept_to_retrieve'
        //  1-start with not_confirmed 
        //  2-user can canceled 
        //  3- store  can confirmed first then rejected or shipping and delevered 
        //  4-user can ask_to_retrieve
        'order_status', // enum default('not_confirmed')
        
        
        
        'store_id', // integer , unsigned , will not delete if store deleted
        'store_title', // string , nullable ,
        'store_note',
        
        'coupon_title', // string , nullable ,
        'coupon_code', // string , nullable ,
        'coupon_discount_type', // enum 'fixed','percent'  default('fixed')
        'coupon_discount', // float , default(0)  ,order_item_sub_totals - discount
            
        //1- user paied with card and shop reject
        //2- user paied with cash or card and ask to ask_to_retrieve from the store_id
        //create cuopon automatic to the user_id with store_id
        'retrieve_price', // retrieve mony from single store as coupon
        'delevery_fee', // float , default(0)  ,delevery fee from single stores
        'order_item_sub_totals', // float , default(0)  ,collect sub_total of table order_items
        'sub_total', // float , default(0)  , (order_item_sub_totals + delevery_fee ) - coupon_discount 
    ];
    // hasMany
        public function order_items(){
            return $this->hasMany(OrderItem::class);
        }    
    
}
