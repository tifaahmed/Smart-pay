<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\ExtraCategory;              // belongsTo

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

    // belongsTo
        public function extra_category(){
            return $this->belongsTo(ExtraCategory::class,'extra_category_id');
        }
}
