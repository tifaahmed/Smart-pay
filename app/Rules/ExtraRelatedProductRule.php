<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\Extra;
use Illuminate\Database\Eloquent\Builder;

class ExtraRelatedProductRule implements Rule
{
    public $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $product_id = $this->product_id;
        $extra = Extra::where('id',$value)->whereHas('product_items',function (Builder $query) use($product_id) {
            $query->where('product_id',$product_id) ;
        })->first();  

        return $extra ? 1 : 0 ;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'this extra not related to the product';
    }
}
