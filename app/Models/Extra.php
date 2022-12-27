<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;

use App\Models\ExtraCategory;            // belongsTo
use App\Models\Store;                    // belongsTo

use App\Models\ProductItem;              // belongsToMany
use App\Models\ProductExtra;             // pivot

use Auth;
class Extra extends Model
{
    use HasFactory , HasTranslations  ;

    protected $table = 'extras';
    protected $primaryKey = 'id';
    protected $fillable = [
        'extra_category_id', // integer , unsigned , // will not delete if extra_category deleted
        'store_id',          // integer , unsigned , onDelete('cascade')

        'title',            //string  , [note: "translatable"]
        'price' ,           //  float , default(0);
        'status',           // string , enum  request_as_new request_as_edit active  deactivate out_of_stock
    ];
    public $translatable = [
        'title'
    ];
    public $scopes = [
        'relate_auth_store','store_status','product_id',
    ];
    // scope
        // relate_auth_store
        public function scopeRelateAuthStore($query,$filter){
            if ($filter == false) {
                return $query->where('store_id','!=' ,Auth::user()->store->id);
            }
            return $query->where('store_id',Auth::user()->store->id);
        }
        // store_status
        public function scopeStoreStatus($query,$filter){
            return $query->whereHas('store',function (Builder $query) use($filter) {
                $query->where('status',$filter) ;
            });            
        }
        // product_id
        public function scopeProductId($query,$filter){
            return $query->whereHas('product_items',function (Builder $query) use($filter) {
                $filter ? $query->where('product_id',$filter) : $query ;
            });
        }

    // belongsTo
        public function extra_category(){
            return $this->belongsTo(ExtraCategory::class,'extra_category_id');
        }
        public function store(){
            return $this->belongsTo(Store::class,'store_id');
        }
    // belongsToMany    
        public function product_items(){
            return $this->belongsToMany(ProductItem::class, ProductExtra::class, 'extra_id', 'product_id')
            ->using(ProductExtra::class);
        }      
}
