<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Notifications\ResetPassword;

use App\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

// Notification
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\ActiveEmailNotification;
use App\Notifications\SentOtpPhoneNotification;


use Auth;

use App\Models\Store;                // HasOne , belongsToMany
use App\Models\ProductItem;         //  belongsToMany

use App\Models\UserFavStore;            // pivot
use App\Models\UserFavProduct;          // pivot
use App\Models\UserRateStore;           // pivot
    
use App\Models\Order;          // HasMany
use App\Models\Address;        // HasMany
use App\Models\Cart;           // HasMany


class User extends Authenticatable
{
    use
        HasApiTokens ,
        HasFactory   ,
        HasRoles     ,
        SoftDeletes ,
        Notifiable
    ;
    protected $guard_name = 'sanctum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',// string
        'last_name', // string / nullable

        'email',  // string  /unique / nullable
        'password', // string
        
        'login_type',   // enum / 'google','facebook','normal; / default: normal
        'gender',   // enum / 'girl','boy' / default: boy
        'phone',    // string  /unique / nullable
        'birthdate', //  date  / nullable
        'email_verified_at',  // datetime   / nullable
        'phone_verified_at',  // datetime   / nullable

        'avatar', // string(file) / nullable

        'pin_code', // integer / nullable / unique

        'fcm_token', // string / nullable 
        'latitude', // string / nullable
        'longitude', // string / nullable

        'token', // string / nullable / unique
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // boot
    protected static function boot()
    {
        parent::boot();
        User::creating(function ($model) {
            $model->pin_code = rand(111111,999999);
        });
        User::updating(function ($model) {
            $model->pin_code = rand(111111,999999);
        });
    }

    //scope
        public function getFullNameAttribute(){
            return $this->first_name . ' ' .$this->last_name;
        }
         

        public function scopeRelateUser($query,$user_id){
            return $query->where('user_id',$user_id);
        }
        public function scopeRelateAuth($query){
            return $query->where('user_id',Auth::user()->id);
        }

    //relations
        // HasMany
            public function orders(){
                return $this->HasMany(Order::class);
            }
            public function address(){
                return $this->HasMany(Address::class);
            }
            public function carts(){
                return $this->HasMany(Cart::class);
            }
            
        // HasOne
            public function store(){
                return $this->hasOne(Store::class);
            }
        // belongsToMany    
            public function fav_stores(){
                return $this->belongsToMany(Store::class, UserFavStore::class, 'user_id', 'store_id')
                ->using(UserFavStore::class);
            }
            public function fav_products(){
                return $this->belongsToMany(ProductItem::class, UserFavProduct::class, 'user_id', 'product_id')
                ->using(UserFavProduct::class);
            } 
            public function rate_stores(){
                return $this->belongsToMany(Store::class, UserRateStore::class, 'user_id', 'store_id')
                ->using(UserRateStore::class)
                ->withPivot('rate');
            }
  
    //relations


    

    public function getToken( ) : array { // sanctum
        $token = $this -> createToken( $this->remember_token ?  $this->remember_token : $this->email   )  ; 
        return [
            'token_type'        =>  'Bearer' ,
            'expires_in'        =>  null ,
            'name_token'        =>  null,
            'access_token'      =>  $token ->plainTextToken ,
            'refresh_token'     =>  null ,
            'updated_at_token'  =>  null ,
            'created_at_token'  =>  null ,
        ] ; 
    }
    // public function getToken( ) : array {   // passport

    //     $token = $this -> createToken( $this->remember_token ?  $this->remember_token : '' )->accessToken;
    //     return [
    //     'token_type'        =>  'Bearer' ,
    //     'expires_in'        =>  $token -> expires_in ,
    //     'name_token'        =>  $token -> name,
    //     'access_token'      =>  $token -> token ,
    //     'refresh_token'     =>  null ,
    //     'updated_at_token'  =>  $token -> updated_at ,
    //     'created_at_token'  =>  $token -> created_at ,
    //     ] ; 
    // }


    // Notification

        public function sendPasswordResetNotification($token)
        {
            $url = asset('reset-password'.$token);

            $data = [] ;
            $data += ['url' => $url];
            $data += ['pin_code' => $this->pin_code];

            $this->notify(new ResetPasswordNotification($data));
        }
        public function sendActiveEmailNotification()
        {
            $data = ['pin_code' => $this->pin_code];
            $this->notify(new SentOtpPhoneNotification($data));
        }


    // Notification

}
