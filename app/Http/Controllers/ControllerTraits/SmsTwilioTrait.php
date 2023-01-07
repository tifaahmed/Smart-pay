<?php
namespace App\Http\Controllers\ControllerTraits;

use Illuminate\Http\JsonResponse ;
use Twilio\Rest\Client;
trait SmsTwilioTrait {

    // public function __construct()
    // {

    //     $this->twilio_sid = "AC8b8993cbdb6e5c72141752d2fd8ba9da" ;
    //     $this->auth_token = "4c2ea5b8e9f1b701080f183e71f12cf3" ;
    //     $this->twilio_verify_sid = "VA0276b4e49dca4e95e64bdd8e71fca04e" ;
    // }
    public function OtpSend(  $phone_number  ) :bool {
        
        $twilio_sid = "AC8b8993cbdb6e5c72141752d2fd8ba9da" ;
        $auth_token = "4c2ea5b8e9f1b701080f183e71f12cf3" ;
        $twilio_verify_sid = "VA0276b4e49dca4e95e64bdd8e71fca04e" ;

        $twilio = new Client($twilio_sid, $auth_token);
        
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($phone_number, "sms");

        return     $verification->status ? true : false ;


        
    }
    public function OtpChecks(  $phone_number  , string $verification_code ):bool {
        $twilio_sid = "AC8b8993cbdb6e5c72141752d2fd8ba9da" ;
        $auth_token = "4c2ea5b8e9f1b701080f183e71f12cf3" ;
        $twilio_verify_sid = "VA0276b4e49dca4e95e64bdd8e71fca04e" ;

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