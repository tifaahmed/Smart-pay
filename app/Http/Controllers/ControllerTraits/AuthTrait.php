<?php

namespace App\Http\Controllers\ControllerTraits;

use Illuminate\Http\JsonResponse ;
use Illuminate\Support\Facades\Hash;
 use App\Models\User ;
 use Illuminate\Support\Str;
 use Illuminate\Support\Facades\Auth;

trait AuthTrait {
    // verification
        
        // * @param   $user object (model)
        // return false if email or phone verified
        // return true if email or phone (not) verified
        public function check_verification($user): bool {
            $falg = false ; 
            if ($user->email) {
                $falg =    $this->check_email_verified($user);
            }else if($user->phone){
                $falg =   $this->check_phone_verified($user);
            }
            return $falg;
        }

        // * @param   $user object (model)
        // return false if email_verified
        // return true if (not) email_verified & send code to mail 
        public function check_email_verified($user) :bool{
            // if not verified send pin code
            if ($user->email_verified_at) {
                return false;
            }else{
                $user->sendActiveEmailNotification();
                return true;
            }
        }
        // * @param   $user object (model)
        // return false if phone_verified
        // return true if (not) phone_verified & send code to phone 
        public function check_phone_verified($user) :bool {
            // if not verified send pin code
            if ($user->phone_verified_at) {
                return false;
            }else{
                $user->sendActivePhoneNotification();
                return true;
            }
        }
    // verification
    
    // get user model
        // * @param   $email_phone string 
        // return object if phone or email exist
        // return null if phone or email (not) exist
        public function get_user ($email_phone) :object {
            if(is_numeric($email_phone)){
                $user = User::where( 'phone' , $email_phone ) -> first( ) ;
            }else {
                $user = User::where( 'email' , $email_phone ) -> first( ) ;
            }
            return  $user;
        }
    // get user model



    public function update_auth_fcm_token($fcm_token) :void{
        $fcm_token ?    Auth::user()->update(['fcm_token'=>$fcm_token]) : null;
    }



    // * @param   $request  array
    // return obj (model)  
    public function store($request ) :object {
        $all = [ ];


        $all += $request -> get( 'first_name' ) ?
        array( 'first_name' => $request -> get( 'first_name' ) )
        :
        array( 'first_name' => 'unknown' );

        $all += array( 'email'      => $request -> get( 'email' ) );
        $all += array( 'phone'      => $request -> get( 'phone' ) );

        $file_one = 'avatar';
        if ($request->hasFile($file_one)) {            
            $all += $this->HelperHandleFile($this->folder_name,$request->file($file_one),$file_one)  ;
        }

        $all += $request -> get( 'token' ) ?
            array( 'token'       => $request -> get( 'token' )  )
            :
            array( 'token'       => Hash::make( Str::random(60) ) );

        $all += $request -> get( 'token' ) ?
            array( 'remember_token'       => $request -> get( 'token' )  )
            :
            array( 'remember_token'       => Hash::make( Str::random(60) ) );


        $all += $request -> get( 'password' ) ?
            array( 'password'       => Hash::make( $request -> get( 'password' ) ) )
            :
            (
                $request -> get( 'token' ) ?
                array( 'password'       => $request -> get( 'token' )  )
                :
                array( 'password'       => Hash::make('social') )
            );

        $all += $request -> get( 'login_type' ) ?
            array( 'login_type' => $request->login_type )
            :
            array( 'login_type' => 'normal' );

        $all += $request -> get( 'last_name' ) ?
            array( 'last_name' => $request -> get( 'last_name' ) )
            :
            [];
        $all += $request -> get( 'gender' ) ?
            array( 'gender' => $request->gender  )
            :
            [];  
        $all += $request -> get( 'birthdate' ) ?
            array( 'birthdate' => $request->birthdate )
            :
            []; 

        $all += $request -> get( 'login_type' ) && $request->login_type != 'normal' ?
            array( 'email_verified_at' =>  date("Y-m-d H:i:s") )
            :
            [];
        $all += $request -> get( 'fcm_token' ) ?
            array( 'fcm_token' => $request ->fcm_token )
            :
            [];
        $all += $request -> get( 'latitude' ) ?
            array( 'latitude' => $request ->latitude )
            :
            [];
        $all += $request -> get( 'longitude' ) ?
            array( 'longitude' => $request ->longitude )
            :
            [];
        $user =   User::create($all);  
        // gave customer role
        $user->assignRole('customer');

        return  $user;
    }
}