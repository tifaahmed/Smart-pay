<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth ;
use App\Models\User;              // belongsTo
use App\Models\City;              // belongsTo
use App\Models\Order;           // HasMany

class Address extends Model
{
    use HasFactory;

    protected $table = 'about_us';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',  // integer , unsigned , onDelete('cascade')
        'city_id',  // integer , unsigned ,  will not delete if city deleted
        'city_name',
        'address',  // text  
        'department',  // string  ,nullable
        'house',  // string  ,nullable
        'street',  // string  ,nullable
        'note',  // text  ,nullable
        'floor',  // number  ,nullable
        'type', // enum , 'home', 'work', 'rest' ,'mosque'

        'latitude',  // string  ,nullable
        'longitude',  // string  ,nullable
    ];
    public $scopes = [
        'relate_auth_user'
    ];
    //scope
        public function scopeRelateAuthUser($query){
            return $query->where('user_id',Auth::user()->id);
        }
    // set    
        public function setCityNameAttribute($value){
            return $this->attributes['city_name'] = $this->city->name;
        }

    // reations    
        // belongsTo
            public function user(){
                return $this->belongsTo(User::class,'user_id');
            }
            public function city(){
                return $this->belongsTo(City::class,'city_id');
            }
}

 