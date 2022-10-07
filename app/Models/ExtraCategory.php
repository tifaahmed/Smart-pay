<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Extra;              // HasMany

class ExtraCategory extends Model
{
    use HasFactory , HasTranslations  ;

    protected $table = 'extra_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',           //string  , [note: "translatable"]
        'type'  //  enum , 'radio'- 'checkbox'
    ];
    public $translatable = [
        'title'
    ];

    // scope
    public function scopeProductFilter($query,$filter){
        $product_id = $filter  ??  null;
        return $query->whereHas('extras',function (Builder $extras_query) use($product_id) {
            $extras_query->whereHas('product_items',function (Builder $query) use($product_id) {
                $product_id ? $query->where('product_id',$product_id) : $query ;
            });        
        });
    }

    // HasMany
        public function extras(){
            return $this->HasMany(Extra::class);
        }
}
