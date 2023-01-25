<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
class AboutUs extends Model
{
    use HasFactory , HasTranslations ;
    protected $table = 'about_us';
    protected $primaryKey = 'id';

    protected $fillable = [

        'title_one',  // string  ,nullable
        'title_two',  // string  ,nullable
        'subject_one',  // text  ,nullable
        'type', // enum => 'information', 'terms'/ default =>'information'

    ];
    public $translatable = [
        'title_one',            
        'title_two',            
        'subject_one',            
    ];
}
 