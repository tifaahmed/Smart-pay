<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use App\Models\Store; // belongsToMany
use App\Models\FoodSectionStore; // pivot

class FoodSection extends Model
{
    use HasFactory , HasTranslations  ;

    protected $table = 'food_sections';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', // text  translatable
        'description', // text ,nullable translatable
        'image', // string
    ];
    public $translatable = [
        'title', // text  translatable
        'description', // text ,nullable translatable    
    ];
    public function fav_products(){
        return $this->belongsToMany(Store::class, FoodSectionStore::class, 'food_section_id', 'store_id')
        ->using(FoodSectionStore::class);
    } 
}
 