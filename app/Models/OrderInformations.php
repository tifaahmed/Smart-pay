<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order; // belongsTo

class OrderInformations extends Model
{
    use HasFactory;

    protected $table = 'order_informations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id', // integer , unsigned , cascade

        'user_full_name', // string , 
        'phone', // string , 

        'address', // text , 
        'department', // string , 
        'house', // string , 
        'street', // string , 
        'note', // text , 
        'type', // enum , ['home', 'work', 'rest' ,'mosque'] , default('home')

        'city_name', // string , 

        'latitude', // string , 
        'longitude', // string , 
    ];
    // belongsTo
        public function order(){
            return $this->belongsTo(Order::class,'order_id');
        }

}
