<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FoodSectionStore extends Pivot
{
    use HasFactory;
    protected $table = 'food_section_stores';

}
