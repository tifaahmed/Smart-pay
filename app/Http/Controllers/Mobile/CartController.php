<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Auth;

// Resource
use App\Http\Resources\Mobile\Collections\CartCollection as ModelCollection;
use App\Http\Resources\Mobile\Cart\CartResource as ModelResource;

// lInterfaces
use App\Repository\CartRepositoryInterface as ModelInterface;
use App\Repository\CartExrtraRepositoryInterface;

// Requests
use App\Http\Requests\Api\Mobile\Cart\CartStoreApiRequest as modelInsertRequest;
use App\Http\Requests\Api\Mobile\Cart\CartUpdateApiRequest as modelUpdateRequest;
use App\Http\Requests\Api\Mobile\Cart\CartRelatedApiRequest as modeRelatedRequest;

class CartController extends Controller
{
    private $Repository;
    private $CartExrtraRepository;
    public function __construct(
        ModelInterface $Repository,
        CartExrtraRepositoryInterface $CartExrtraRepository,
    ){
        $this->ModelRepository = $Repository;
        $this->CartExrtraRepository = $CartExrtraRepository;
        $this->default_per_page = 10;
    }


    public function all(Request $request){
        try {
            $modal =    $this->ModelRepository->all()    ;
            return new ModelCollection($modal);
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }



    public function store(modelInsertRequest $request) {
        try {
            // @return the repeated object 
                $repeated_cart_product = $this->getRepeatedProduct($request->product_id,$request->extra_ids);
            
            // if repeated inside cart increase quantity
                if ($repeated_cart_product) {
                    $arr = ['quantity' => $repeated_cart_product->quantity +  $request->quantity] ;
                    $this->ModelRepository->update($repeated_cart_product->id, $arr );
                    $cart = $this->ModelRepository->findById($repeated_cart_product->id);
                }
            // new product or same product but deffrent extra
                else{
                    // @return the cart array with the  product data
                    $cart_arr = $this->cart_arr($request->product_id ,$request->quantity );
                    $cart = $this->ModelRepository->create(  $cart_arr ) ;
        
                    if ($request->extra_ids) {
                        foreach ($request->extra_ids as $key => $extra_id) {
                            $extra_arr = $this->extra_arr($cart->id,$extra_id);
                            $this->CartExrtraRepository->create( $extra_arr ) ;
                        }
                    }
                }

            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $cart ) ],
                'Successful',
                Response::HTTP_OK
            ) ;
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_BAD_REQUEST
            );
        }
    }
    public function update(modelUpdateRequest $request, $id) {

        if ($request->quantity <= 0) {
            $this->ModelRepository->deleteById($id);
        }else{
            $arr = ['quantity' =>   $request->quantity] ;
            $this->ModelRepository->update($id, $arr );


            $cart = $this->ModelRepository->findById($id);
            //get_the removed()
            foreach ($cart->extra_ids as $key => $extra_id) {

                $this->CartExrtraRepository->deleteById($extra_id);
                return dd( $extra_id );

            }
            if ($request->extra_ids) {
                return dd( $request->extra_ids );

                foreach ($request->extra_ids as $key => $extra_id) {
                    $this->CartExrtraRepository->create( $extra_arr ) ;
                }
            }
            
        }

    }
    public function destroy(modeRelatedRequest $request, $id) {
        try {
            $this->ModelRepository->deleteById($id);
            return $this -> MakeResponseSuccessful( 
                [ ],
                'Successful',
                Response::HTTP_OK
            ) ;
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [ $e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
