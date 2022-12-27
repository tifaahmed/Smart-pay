<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\ProductItem;

class ProductAcceptedStoreRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $product_item = ProductItem::where('id', $value )
        ->whereHas('store' ,function ($query) {
            $query->where('status','accepted') ;
        })->first();


 
        return $product_item ? 1 : 0 ;
          
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'store not working.';
    }
}
