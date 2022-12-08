<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order; // belongsTo

class OrderInformation extends Model
{
    use HasFactory;

    protected $table = 'order_informations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id', // integer , unsigned , cascade

        'user_full_name', // string , 
        'phone', // string ,// nullable 
        'email', // string , ,// nullable 
        
        'address', // text , 
        'department', // string , ,// nullable 
        'house', // string , ,// nullable 
        'street', // string , ,// nullable 
        'note', // text , ,// nullable 
        'type', // enum , ['home', 'work', 'rest' ,'mosque'] , default('home')

        'city_id', // integer , will be deleted if order deleted
        'city_name', // string ,,// nullable 
        
        'latitude', // string , ,// nullable 
        'longitude', // string , ,// nullable 
    ];
    // belongsTo
        public function order(){
            return $this->belongsTo(Order::class,'order_id');
        }

}
