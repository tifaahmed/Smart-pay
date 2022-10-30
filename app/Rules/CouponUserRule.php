<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Auth;
use App\Models\Coupon;

class CouponUserRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $coupon = Coupon::where('code',$value)->first();
        if (!$coupon || !$coupon->user_id) {
            return 1;
        }else {
            return $coupon->user_id && $coupon->user_id == Auth::user()->id ? 1 : 0 ;    
        }    
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'code can not be used by you.';
    }
}
