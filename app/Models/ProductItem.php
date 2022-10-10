<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

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
        'store_id',  // integer , unsigned
        'product_category_id',  // integer , unsigned
        
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

    //scope
    public function scopeStoreFilter($query,$filter){
        $store_id = $filter && $filter['StoreFilter']  ? $filter['StoreFilter'] : null;
        return $store_id ? $query->where('store_id',$store_id) : $query;
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
