<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cart;       // belongsTo
use App\Models\Extra;      // belongsTo

class CartExtra extends Model
{
    use HasFactory ;
    protected $table = 'cart_extras';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cart_id',  // integer , onDelete('cascade')

        'extra_id', //integer , will not delete if extra deleted
        'extra_title', //string , nullable  
        'extra_price', //float , default(0)  

    ];
    // belongsTo
        public function cart(){
            return $this->belongsTo(Cart::class,'cart_id');
        }
        public function extra(){
            return $this->belongsTo(Extra::class,'extra_id');
        }
}
