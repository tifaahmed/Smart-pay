<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;

// lInterfaces
use App\Repository\OrderStoreRepositoryInterface as ModelInterface;

// Resource
use App\Http\Resources\Mobile\Collections\OrderStoreCollection as ModelCollection;
use App\Http\Resources\Mobile\OrderStore\OrderStoreResource as ModelResource;

// Requests
use App\Http\Requests\Api\Dashboard\OrderStore\OrderStoreUpdateApiRequest as modelUpdateRequest;

class OrderStoreController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
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
    public function collection(Request $request){
        try {
            $modal = $this->ModelRepository->collection( $request->per_page ?? $this->default_per_page);
            return new ModelCollection($modal);
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }
    public function show($id) {
        try {
            $model = $this->ModelRepository->findById($id);
            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $model ) ],
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

    public function update(modelUpdateRequest $request ,$id) {
        try {
            $arr = [];
            $arr += ['order_status' =>$request->order_status] ;
            if ($user->hasRole('store')) {
                $arr += ['store_note' =>$request->store_note] ;
                $arr += ['retrieve_price' =>$request->retrieve_price] ;
            }

            $this->ModelRepository->update( $id, $arr  ) ;
            $model =  $this->ModelRepository->findById($id) ;

            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $model ) ],
                    'Successful' ,
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
