<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;

use App\Models\User;              // belongsTo / belongsToMany
use App\Models\FoodSection; // belongsToMany

use App\Models\UserFavStore;      // pivot
use App\Models\UserRateStore;      // pivot
use App\Models\FoodSectionStore; // pivot

use App\Models\ProductItem;          // HasMany
use App\Models\OrderItem;          // HasMany


use Auth;
class Store extends Model
{
    use HasFactory , HasTranslations , SoftDeletes;


    protected $table = 'stores';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',  // int / unsigned

        'title',       //text  [note: "store name"]
        'description', //text  [note: "store information"]
        
        'delevery_fee', // float , default : 0
        
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
    public $append = [
        'distance', 
    ];
    
    //scope
        public function scopeFoodSection($query,$filter){
            return $query->whereHas('food_sections',function (Builder $query) use($filter) {
                $filter && is_numeric($filter) ? $query->where('food_section_id',$filter) : null ;
            });
        }
        public function scopeFreeDelevery($query,$filter){
            if ($filter == 0 || $filter == false) {
                return $query->where('delevery_fee',0)->orWhere('delevery_fee',null);
            }else{
                return $query->where('delevery_fee',$filter);
            }
        }
        public function scopeOffer($query,$filter){
            return $query->whereHas('product_items',function (Builder $query) use($filter) {
                $query->where('discount',$filter);
            });
        }
        public function scopeNearest($query,...$nearest)
        {
            // if sent the location
            if ( is_array($nearest) && count($nearest) == 3 && $nearest[0] && $nearest[1] && $nearest[2]) {
                $latitude = $nearest[0];
                $longitude  = $nearest[1];
                $distance = $nearest[2];
            }
            // else get old location
            else if (Auth::user() &&  Auth::user()->latitude &&  Auth::user()->longitude) {
                $latitude = Auth::user()->latitude ;
                $longitude  = Auth::user()->longitude;
                $distance = 500;
            }
            // do nothing
            else{
                return $query->select("*")->selectRaw("0 AS distance");
            }

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
        public function product_items(){
            return $this->HasMany(ProductItem::class);
        }
        public function order_item(){
            return $this->HasMany(OrderItem::class);
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
        public function food_sections(){
            return $this->belongsToMany(FoodSection::class, FoodSectionStore::class, 'store_id', 'food_section_id')
            ->using(FoodSectionStore::class);
        }  

}
