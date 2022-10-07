<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

// Resource
use App\Http\Resources\Mobile\Collections\StoreCollection as ModelCollection;
use App\Http\Resources\Mobile\Store\StoreResource as ModelResource;

// lInterfaces
use App\Repository\StoreRepositoryInterface as ModelInterface;

// Requests
use App\Http\Requests\Api\Mobile\Store\StoreRateApiRequest ;
use App\Http\Requests\Api\Mobile\Store\StoreFavApiRequest ;

class StoreController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->default_per_page = 10;
    }

    
    public function all(Request $request){
        try {
            $model =  $this->ModelRepository->filterAll($request->filter) ;
            return new ModelCollection($model);
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
            $model = $this->ModelRepository->filterPaginate($request->filter, $request->prepage ?? 10);
            return new ModelCollection($model);
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
    public function fav_toggle(StoreFavApiRequest $request) {
        try {
            $model = $this->ModelRepository->findById($request->store_id);
            $fav_roducts = $model->fav_stores();

            if (!$fav_roducts->RelateUser(Auth::user()->id)->first()) {
                $fav_roducts ->syncWithoutDetaching(Auth::user()->id);
            }else{
                $fav_roducts ->detach(Auth::user()->id);
            }
           
            return $this -> MakeResponseSuccessful( 
                [ 'Successful' ],
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
    public function rate(StoreRateApiRequest $request) {
        try {
            $model = $this->ModelRepository->findById($request->store_id);
            $rate_stores = $model->rate_stores();
            $rate_stores->syncWithoutDetaching([Auth::user()->id =>['rate' =>$request->rate] ]);

            $sum =   $rate_stores->sum('rate');
            $count =   $rate_stores->count();
            $model->update(['rate' => $sum / $count]);

            return $this -> MakeResponseSuccessful( 
                [ 'Successful' ],
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
