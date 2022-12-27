<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Controllers\ControllerTraits\SmsTwilioTrait;
class OtpChecksRule implements Rule
{
    use  SmsTwilioTrait;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $email_phone;

    public function __construct($email_phone)
    {
        $this->email_phone = $email_phone;
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
        // first  phone
        // second pin_code
        
        return $this->OtpChecks($this->email_phone,$value) ? true : false ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Otp is wrong.';
    }
}
