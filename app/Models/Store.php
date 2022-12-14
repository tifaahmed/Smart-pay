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
use App\Models\OrderStore;          // HasMany
use App\Models\Subscription;          // HasMany


use Auth;
class Store extends Model
{
    use HasFactory , HasTranslations , SoftDeletes;


    protected $table = 'stores';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',  // int / unsigned

        'status', //enum  /'pending', 'accepted', 'rejected' ,'canceled' , 'busy' /default('pending') 
        
        'image',       //string  nullable

        'title',       //text    nullable
        'description', //text nullable
        'phone',    // string

        'rate',  // float / default : 5
        'delevery_fee', // float , default : 0
        
        'address', // text,nullable
        'streat', // string,nullable
        'building', // string,nullable
        
        'city_id', // integer, nullable
        'city_name', // string, nullable
        
        'latitude', // string
        'longitude', // string
        

    ];
    public $translatable = [
        'title', 
        'description' ,  
        'city_name'        
    ];
    public $append = [
        'distance', 
    ];
    // filter scopes
        public $scopes = [
            'food_section','free_delevery','offer','nearest','relate_auth_user','subscripted_store'
        ];
    //scope
        // food_section
        public function scopeFoodSection($query,$filter){
            return $query->whereHas('food_sections',function (Builder $query) use($filter) {
                $filter && is_numeric($filter) ? $query->where('food_section_id',$filter) : null ;
            });
        }
        // free_delevery
        public function scopeFreeDelevery($query,$filter){
            if ($filter == 0 || $filter == false) {
                return $query->where('delevery_fee',0)->orWhere('delevery_fee',null);
            }else{
                return $query->where('delevery_fee',$filter);
            }
        }
        // offer
        public function scopeOffer($query,$filter){
            return $query->whereHas('product_items',function (Builder $query) use($filter) {
                $query->where('discount',$filter);
            });
        }

        // subscripted_store
        public function scopeSubscriptedStore($query,$filter){
            return $query->whereHas('subscriptions',function ($subscription_query)  {
                $subscription_query->whereDate('end_date','>=',date('Y-m-d')) ;
                $subscription_query->AcceptedStatus() ;
            });            
        }
        // relate_auth_user
        public function scopeRelateAuthUser($query){
            return $query->where('user_id',Auth::user()->id);
        }

        // nearest
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
                $latitude = Auth::user()->latitude;
                $longitude  = Auth::user()->longitude;
                $distance = 5000;
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
                ->having("distance", "<=", $distance)->orderby("distance", "desc");
        }

    // HasMany
        public function product_items(){
            return $this->HasMany(ProductItem::class);
        }
        public function order_items(){
            return $this->HasMany(OrderItem::class);
        }
        public function order_stores(){
            return $this->HasMany(OrderStore::class);
        }
        public function subscriptions(){
            return $this->HasMany(Subscription::class);
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
