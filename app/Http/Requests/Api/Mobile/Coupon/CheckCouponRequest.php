<?php

namespace App\Http\Requests\Api\Mobile\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\CouponUsageLimitRule;
use App\Rules\CouponUserRule;
use App\Rules\CouponWorkingRule;
use App\Rules\CouponDateRule;

use App\Models\Coupon;

class CheckCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {    

        $lang_array = config('app.lang_array') ;
        
        $all=[];
        $all += [ 'code' =>  [ 'required',
         'exists:'.Coupon::class.',code' ,
         new CouponUsageLimitRule(),
         new CouponUserRule(),
         new CouponWorkingRule(),
         new CouponDateRule(),
         
         ] ]  ;

        
        return $all;
    }
}
