<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Models\Coupon;

class CouponUsageLimitRule implements Rule
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
        $coupon = Coupon::where('code',$value)->first();
        if (!$coupon) {
            return 1;
        }else {
            return $coupon->usage_counter   >= $coupon->usage_limit ? 0 : 1 ;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'code exceeded the limit.';
    }
}
