<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\Mobile\Auth\loginApiRequest ;
use App\Http\Requests\Api\Mobile\Auth\RegisterApiRequest ;
use App\Http\Requests\Api\Mobile\Auth\CheckPinCodeRequest ;

use App\Models\User ;

use Illuminate\Http\Response ;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\Mobile\Auth\AuthResource;


use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;


class AuthController extends Controller {
 
    public function __construct(){
        $this->folder_name = 'user/'.Str::random(10).time();
        $this->file_columns = ['avatar'];
    }

    public function login( loginApiRequest $request ) {

        // return object if phone or email exist
        $user = $this->get_user($request->email_phone);
            
        // if the user password wrong
        if ( ! Hash::check( $request -> password , $user -> password ) ) {
            // if user password wrong &  sign by google
            if( $user->login_type ){
                return $this -> MakeResponseErrors( 
                    [ 'InvalidCredentials' ],  
                    'first login type '.$user->login_type ,
                    Response::HTTP_UNAUTHORIZED
                ) ;
            }
            // if user password wrong &  sign normal
            else{
                return $this -> MakeResponseErrors( 
                    [ 'InvalidCredentials' ],  
                    'error' ,
                    Response::HTTP_UNAUTHORIZED
                ) ; 
            }
        }
        // return true if email or phone (not) verified        
        else if( $this->check_verification($user) ){
            return $this -> MakeResponseErrors( 
                [ 'acount not verified pincode has been sent' ],  
                'error' ,
                Response::HTTP_UNAUTHORIZED
            ) ;
        }
        
        // login user
        else {
            return $this->loginUser($user);
        }
    }

    public function loginSocial( Request $request ) {
        // return object if phone or email exist
        $user = $this->get_user($request->email);
            
        // if not exist create user
        $user = $user ?? $this->store_user($request) ;

        return $this->loginUser($user); // login
    }

    public function register( RegisterApiRequest $request ) {
        $user = $this->store_user($request) ; // store user 

        if ($request->email) {
            $this->check_email_verified($user); // send pin code to user email
        }
        if ($request->phone) {
            $this->OtpSend($user->phone);
        }
        return $this->loginUser($user); // login
    }

    public function logout( Request $request ) {
        Auth::user()->tokens()->delete(); // Sanctum
        // Auth::user()->token()->revoke();// passport
        // Auth::user()->currentAccessToken()->delete(); // passport
        return $this -> MakeResponseSuccessful( 
            ['Successful' ],
            'Successful' ,
            Response::HTTP_OK
         ) ;
    }


    


    public function active_acount(CheckPinCodeRequest $request){

        $user = $this->get_user($request->email_phone);

        
        // if ($user) {
            // $this->OtpChecks($user->phone,$request->pin_code);// validation 
            if ($user->email) {
                $user->update([ 'email_verified_at' => date("Y-m-d H:i:s") ]);
            }
            if($user->phone){
                $user->update([ 'phone_verified_at' => date("Y-m-d H:i:s") ]);
            }
            return $this ->loginUser($user);
        // }else{
        //     return $this -> MakeResponseSuccessful( 
        //         [ 'message' => 'InvalidCredentials' ],  
        //         'InvalidCredentials' ,
        //         Response::HTTP_UNAUTHORIZED
        //     ) ;  
        // }
    }
    




        public function loginUser($user)
        {   
            //  user Auth
            Auth::loginUsingId($user->id);

            // update auth user  fcm_token if exist
            $this->update_auth_fcm_token($user->fcm_token);

            // login Response
            return $this->authResponse();
        }

        public function authResponse () {
            return $this -> MakeResponseSuccessful( 
                [
                    'user'  =>   new AuthResource ( Auth::user()   )   , 
                    'Token' => Auth::user() -> getToken( ) 
                ],  
                'Successful' ,
                Response::HTTP_OK
            ) ; 
        }
        
    // inside functions


}
