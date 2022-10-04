<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
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

    // HasMany
        public function sxtras(){
            return $this->HasMany(Extra::class);
        }
}
