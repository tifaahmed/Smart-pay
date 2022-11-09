<?php

namespace App\Http\Resources\Mobile\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $all=[];
        $all += [ 'id' =>   $this->id ]  ;
        $all += [ 'roles' =>  $this->roles->pluck('name') ]  ;


        $all += [ 'first_name' =>   $this->first_name ]  ;
        $all += [ 'last_name' =>   $this->last_name ]  ;

        $all += [ 'login_type' =>   $this->login_type ]  ; // enum / 'google','facebook','normal; / default: normal
        $all += [ 'email' =>   $this->email ]  ; // string / unique
        $all += [ 'gender' =>   $this->gender ]  ;// enum / 'girl','boy' / default: boy
        $all += [ 'phone' =>   $this->phone ]  ;  // string  / nullable
        $all += [ 'birthdate' =>   $this->birthdate ]  ; //  date  / nullable
        $all += [ 'email_verified_at' =>   $this->email_verified_at ]  ; // date   / nullable
        $all += [ 'phone_verified_at' =>   $this->phone_verified_at ]  ; // date   / nullable

        $all += [ 'fcm_token' =>   $this->fcm_token ]  ;  // string / nullable 
        $all += [ 'latitude' =>   $this->latitude ]  ;  // string / nullable 
        $all += [ 'longitude' =>   $this->longitude ]  ;  // string / nullable 

 

        $all += [ 'avatar' =>  
        $this->avatar && Storage::disk('public')->exists( $this->avatar)
        ? 
        asset(Storage::url( $this->avatar ) )  
        : 
        null
        ]  ;
        



        return $all;
    }
}
