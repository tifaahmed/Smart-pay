<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Auth;

use App\Models\ProductCategory;     // belongsTo
use App\Models\Store;              // belongsTo

use App\Models\Extra;              // belongsToMany
use App\Models\User;               // belongsToMany
use App\Models\UserFavProduct;               // belongsToMany
use App\Models\UserRateProduct;               // belongsToMany

use App\Models\OrderItem;               // HasMany


class ProductItem extends Model
{
    use HasFactory , HasTranslations , SoftDeletes;

    protected $table = 'product_items';
    protected $guarded = ['id'];

    protected $fillable = [
        'store_id',  // integer , unsigned ,   onDelete('cascade')
        'product_category_id',  // integer , unsigned ,  // will not delete if product_category deleted
        
        'title', // string
        'description', // text
        'image', // string

        'discount', // int ,  enum  5 10 15 20 
        'price',   // float / default : 0

        'status', // string , enum  request_as_new request_as_edit active  deactivate out_of_stock
    ];
   
    public $translatable = [
        'title',            
        'description',            
    ];

    // filter scopes
        public $scopes = [
            'relate_auth_store','store_status','my_fav_products','subscripted_store','relate_store'
        ];
    //scope
        // relate_auth_store
        public function scopeRelateAuthStore($query,$filter){
            if ($filter == false) {
                return $query->where('store_id','!=' ,Auth::user()->store->id);
            }
            return $query->where('store_id',Auth::user()->store->id);
        }
        // relate_store
        public function scopeRelateStore($query,$filter){
            if ($filter) {
                return $query->where('store_id',$filter);
            }
            return $query;
        }
        // store_status
        public function scopeStoreStatus($query,$filter){
            return $query->whereHas('store',function (Builder $query) use($filter) {
                $query->where('status',$filter) ;
            });            
        }
        // my_fav_products
        public function scopeMyFavProducts($query,$filter){
            if ($filter == false) {
                return $query->whereHas('fav_products',function (Builder $query) {
                    $query->where('user_id','!=' ,Auth::user()->store->id) ;
                });
            }
            return $query->whereHas('fav_products',function (Builder $query) {
                $query->where('user_id',Auth::user()->store->id) ;
            });
        }
        // subscripted_store
        public function scopeSubscriptedStore($query,$filter){
            return $query->whereHas('store',function ($store_query)  {
                $store_query->whereHas('subscriptions',function ($subscription_query)  {
                    $subscription_query->whereDate('end_date','>=',date('Y-m-d')) ;
                    $subscription_query->AcceptedStatus() ;
                });            
            });            
        }


    // belongsTo
        public function product_category(){
            return $this->belongsTo(ProductCategory::class,'product_category_id');
        }
        public function store(){
            return $this->belongsTo(Store::class,'store_id');
        }

    // belongsToMany    
        public function product_extras(){
            return $this->belongsToMany(Extra::class, 'product_extras', 'product_id', 'extra_id')->using(ProductExtra::class);
        }    
        public function fav_products(){
            return $this->belongsToMany(User::class, UserFavProduct::class, 'product_id', 'user_id')
            ->using(UserFavProduct::class);
        } 
         
}
