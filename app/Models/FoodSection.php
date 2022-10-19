<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Store; // belongsToMany
use App\Models\FoodSectionsStore; // pivot

class FoodSection extends Model
{
    use HasFactory;

    protected $table = 'food_sections';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', // text  translatable
        'description', // text ,nullable translatable
        'image', // string
    ];
    public function fav_products(){
        return $this->belongsToMany(Store::class, FoodSectionsStore::class, 'food_section_id', 'store_id')
        ->using(FoodSectionsStore::class);
    } 
}
 