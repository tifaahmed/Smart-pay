<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use App\Models\Order;           // HasMany
use App\Models\User;           // belongsTo
use App\Models\Store;           // belongsTo

class Coupon extends Model
{
    use HasFactory , HasTranslations ;

    protected $table = 'coupons';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',          // string , nullable , [note: "translatable"]
        'code',           // string , unique 
        'type',           // enum   ,  [ 'fixed','percent'] , default('fixed')
        'usage_limit',    // integer , default(1) , // how many will use it
        'discount',// integer , default(1)
        
        // if type is percent percent_limit will work
        //  if type is fixed  percent_limit will be null
        'percent_limit',    // float , nullable , 
        
        'start_date',    // timestamp , default(DB::raw('CURRENT_TIMESTAMP')) , 

        // if null coupons will never end
        'end_date',    // timestamp , nullable , 

        'user_id', // integer,nullable,unsigned // if to one user
        'store_id' // integer,unsigned 
    ];

    
    public $translatable = [
        'title'
    ];


    // belongsTo
        public function user(){
            return $this->belongsTo(User::class,'user_id');
        }
        public function store(){
            return $this->belongsTo(Store::class,'store_id');
        }
}
