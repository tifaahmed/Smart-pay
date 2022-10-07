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

    
    // scope
    public function scopeStoreFilter($query,$store_id){
        return $query->whereHas('product_items',function (Builder $query) use($store_id) {
            $query->where('store_id',$store_id);
        });
    }
    // HasMany
    public function product_items(){
        return $this->HasMany(ProductItem::class);
    }


}


