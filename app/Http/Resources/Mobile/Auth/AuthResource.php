<?php

namespace App\Http\Resources\Mobile\Auth;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,

            'first_name'           => $this->first_name,
            'last_name'           => $this->last_name, // nullable

            'email'          => $this->email,  // unique nullable
            'phone'           => $this->phone,  // unique nullable

            'login_type'          => $this->login_type,  // enum / 'google','facebook','normal; / default: normal
            
            'gender'           => $this->gender, // enum / 'girl','boy' / default: boy
            'birthdate'           => $this->birthdate,//  date  / nullable
            'email_verified_at'           => $this->email_verified_at,// datetime   / nullable

            'pin_code'           => $this->pin_code,// integer / nullable / unique
            'fcm_token'           => $this->fcm_token,// string / nullable 

            'latitude'           => $this->latitude, // string / nullable
            'longitude'           => $this->longitude, // string / nullable

            // string(file) / nullable
            'avatar'           => $this->image && Storage::disk('public')->exists( $this->image)
            ? 
            asset(Storage::url( $this->image ) )  
            : 
            null,  




            'roles'          => $this->roles->pluck('name')  ,

            'created_at'    => $this->created_at ?   $this->created_at->format('d/m/Y') : null,
            'updated_at'    => $this->updated_at ?   $this->updated_at->format('d/m/Y') : null,
        
 
    
     
 
    
         
        ];
    }
}

