<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;

use App\Models\User;              // HasOne / belongsToMany
use App\Models\UserFavStore;      // belongsToMany
use App\Models\UserRateStore;      // belongsToMany

class Store extends Model
{
    use HasFactory , HasTranslations , SoftDeletes;


    protected $table = 'stores';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'title',       //text  [note: "store name"]
        'description', //text  [note: "store information"]
        'delevery_fee', // float , default : 0
        'user_id',  // int / unsigned
        'status',   // enum / 'pending', 'accepted', 'rejected' ,'canceled'
        'image',   // string / [note: "store logo  pizza"]
        'phone',    // string
        'latitude', // string
        'longitude', // string
        'rate',  // float / default : 5

    ];
    public $translatable = [
        'title', 
        'description'           
    ];

    //scope
        public function scopeFreeDelevery($query){
            return $query->where('delevery_fee',0)->orWhere('delevery_fee',null);
        }

        public function scopeOffer($query,$filter){
            return $query->whereHas('product_item',function (Builder $query) use($filter) {
                $query->where('discount',$filter);
            });
        }
        public function scopeNearest($query,...$nearest)
        {
            $latitude = $nearest[0];
            $longitude  = $nearest[1];
            $distance = $nearest[2];

            $unit = "km";
            
            $constant = $unit == "km" ? 6371 : 3959;
            $haversine = "(
                $constant * acos(
                    cos(radians(" .$latitude. "))
                    * cos(radians(`latitude`))
                    * cos(radians(`longitude`) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. ")) * sin(radians(`latitude`))
                )
            )";
        
            return $query->select("*")->selectRaw("$haversine AS distance")
                ->having("distance", "<=", $distance);
                
        }

    // HasMany
        public function product_item(){
            return $this->HasMany(ProductItem::class);
        }
    // belongsTo
        public function user(){
            return $this->belongsTo(User::class,'user_id');
        }
    // belongsToMany
        public function fav_stores(){
            return $this->belongsToMany(User::class, UserFavStore::class, 'store_id', 'user_id')
            ->using(UserFavStore::class);
        } 
        public function rate_stores(){
            return $this->belongsToMany(User::class, UserRateStore::class, 'store_id', 'user_id')
            ->using(UserRateStore::class)
            ->withPivot('rate');
        } 
}
