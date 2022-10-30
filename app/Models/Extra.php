<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;

use App\Models\ExtraCategory;              // belongsTo

use App\Models\ProductItem;              // belongsToMany
use App\Models\ProductExtra;              // pivot

class Extra extends Model
{
    use HasFactory , HasTranslations  ;

    protected $table = 'extras';
    protected $primaryKey = 'id';
    protected $fillable = [
        'extra_category_id', // integer , unsigned
        'title',           //string  , [note: "translatable"]
        'price'  //  float , default(0);
    ];
    public $translatable = [
        'title'
    ];

    // scope
        public function scopeProductFilter($query,$filter){
            $product_id = $filter && $filter['product_filter']  ? $filter['product_filter'] : null;
            return $query->whereHas('product_items',function (Builder $query) use($product_id) {
                $product_id ? $query->where('product_id',$product_id) : $query ;
            });
        }


    // belongsTo
        public function extra_category(){
            return $this->belongsTo(ExtraCategory::class,'extra_category_id');
        }

    // belongsToMany    
        public function product_items(){
            return $this->belongsToMany(ProductItem::class, ProductExtra::class, 'extra_id', 'product_id')
            ->using(ProductExtra::class);
        }      
}
