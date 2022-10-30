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

use App\Http\Requests\Api\Mobile\Coupon\CheckCouponRequest;


class CouponController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->default_per_page = 10;
    }
    public function check_coupon(CheckCouponRequest $request)
    {
        try {
            $coupon = $this->ModelRepository->findByCode($request->code);
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
