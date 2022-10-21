<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Auth;
// Resource
use App\Http\Resources\Mobile\Coupon\CouponResource as ModelResource;
// lInterfaces
use App\Repository\CouponRepositoryInterface as ModelInterface;


class CouponController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->default_per_page = 10;
    }
    public function check_coupon(Request $request)
    {
        try {
            $coupon = $this->ModelRepository->findByCode($request->code);

            if(empty($coupon)){
                return $this -> MakeResponseSuccessful( 
                    [ 'code exceeded the limit' ],
                    'Error',
                    Response::HTTP_NOT_FOUND  
                ) ;
            }
            if($coupon->usage_counter  >= $coupon->usage_limit){
                return $this -> MakeResponseSuccessful( 
                    [ 'code exceeded the limit' ],
                    'Error',
                    Response::HTTP_METHOD_NOT_ALLOWED  
                ) ;
            }
            if($coupon->user_id && $coupon->user_id == Auth::user()->id){
                return $this -> MakeResponseSuccessful( 
                    [ 'code can not be used by you' ],
                    'Error',
                    Response::HTTP_METHOD_NOT_ALLOWED  
                ) ;
            }
            
            if(!$coupon->working){
                return $this -> MakeResponseSuccessful( 
                    [ 'code disabled' ],
                    'Error',
                    Response::HTTP_NOT_ACCEPTABLE  
                ) ;
            }
            
            if($coupon->start_date > now()){
                return $this -> MakeResponseSuccessful( 
                    [ 'not available yet' ],
                    'Error',
                    Response::HTTP_METHOD_NOT_ALLOWED 
                ) ;
            }
            if($coupon->end_date < now()){
                return $this -> MakeResponseSuccessful( 
                    [ 'code expired' ],
                    'Error',
                    Response::HTTP_METHOD_NOT_ALLOWED 
                ) ;
            }

            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $coupon ) ],
                'Successful',
                Response::HTTP_OK
            ) ;
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
