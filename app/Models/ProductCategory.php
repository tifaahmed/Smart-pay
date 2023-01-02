<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;

use App\Models\ProductItem;              // HasMany

class ProductCategory extends Model
{
    use HasFactory , HasTranslations , SoftDeletes;


    protected $table = 'product_categories';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'title',            //text  / translatable
    ];
    public $translatable = [
        'title',            
    ];
    // filter scopes
    public $scopes = [
        'store_filter',
    ];
    
    // scope
    public function scopeStoreFilter($query,$filter){
        if ($filter) {
            return $query->whereHas('product_items',function (Builder $query) use($filter) {
                $query->where('store_id',$filter);
            });
        }
        return $query;    
    }
    // HasMany
    public function product_items(){
        return $this->HasMany(ProductItem::class);
    }


}


