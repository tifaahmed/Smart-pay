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



    // * @param    $data  array
    // return obj (model)  
    private function store($data)   {
        $all = [ ];


        $all += $data -> get( 'first_name' ) ?
        array( 'first_name' => $data -> get( 'first_name' ) )
        :
        array( 'first_name' => 'unknown' );

        $all += array( 'email'      => $data -> get( 'email' ) );
        $all += array( 'phone'      => $data -> get( 'phone' ) );

        $file_one = 'avatar';
        if ($data->hasFile($file_one)) {            
            $all += $this->HelperHandleFile($this->folder_name,$data->file($file_one),$file_one)  ;
        }

        $all += $data -> get( 'token' ) ?
            array( 'token'       => $data -> get( 'token' )  )
            :
            array( 'token'       => Hash::make( Str::random(60) ) );

        $all += $data -> get( 'token' ) ?
            array( 'remember_token'       => $data -> get( 'token' )  )
            :
            array( 'remember_token'       => Hash::make( Str::random(60) ) );


        $all += $data -> get( 'password' ) ?
            array( 'password'       => Hash::make( $data -> get( 'password' ) ) )
            :
            (
                $data -> get( 'token' ) ?
                array( 'password'       => $data -> get( 'token' )  )
                :
                array( 'password'       => Hash::make('social') )
            );

        $all += $data -> get( 'login_type' ) ?
            array( 'login_type' => $data->login_type )
            :
            array( 'login_type' => 'normal' );

        $all += $data -> get( 'last_name' ) ?
            array( 'last_name' => $data -> get( 'last_name' ) )
            :
            [];
        $all += $data -> get( 'gender' ) ?
            array( 'gender' => $data->gender  )
            :
            [];  
        $all += $data -> get( 'birthdate' ) ?
            array( 'birthdate' =>  $data->birthdate )
            :
            []; 

        $all +=  $data -> get( 'login_type' ) &&  $data->login_type != 'normal' ?
            array( 'email_verified_at' =>  date("Y-m-d H:i:s") )
            :
            [];
        $all +=  $data -> get( 'fcm_token' ) ?
            array( 'fcm_token' =>  $data ->fcm_token )
            :
            [];
        $all +=  $data -> get( 'latitude' ) ?
            array( 'latitude' =>  $data ->latitude )
            :
            [];
        $all +=  $data -> get( 'longitude' ) ?
            array( 'longitude' =>  $data ->longitude )
            :
            [];
        $user =   User::create($all);  
        // gave customer role
        $user->assignRole('customer');

        return  $user;
    }
}