<?php
namespace App\Http\Controllers\ControllerTraits;

use Illuminate\Http\JsonResponse ;
use Twilio\Rest\Client;
trait SmsTwilioTrait {


    public function OtpSend(  $phone_number  ) :bool {
        
        $twilio_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        $twilio = new Client($twilio_sid, $auth_token);
        
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($phone_number, "sms");

        return     $verification->status ? true : false ;


        
    }
    public function OtpChecks(  $phone_number  , string $verification_code ):bool {
        $twilio_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        $twilio = new Client($twilio_sid, $auth_token);

        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create([
                "to" => $phone_number ,
                "code" => $verification_code
            ]);
        return  $verification->status ? true : false ;

    }
}