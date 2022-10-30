<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Auth;
// Resource
use App\Http\Resources\Mobile\Collections\StoreCollection as ModelCollection;
use App\Http\Resources\Mobile\Store\StoreResource as ModelResource;

// lInterfaces
use App\Repository\StoreRepositoryInterface as ModelInterface;

// Requests
use App\Http\Requests\Api\Mobile\Store\StoreRateApiRequest ;
use App\Http\Requests\Api\Mobile\Store\StoreFavApiRequest ;
use App\Http\Requests\Api\Mobile\Store\StoreStoreApiRequest ;
use App\Http\Requests\Api\Mobile\Store\StoreUpdateApiRequest ;

class StoreController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->folder_name = 'store/'.date('Y-m-d-h-i-s');
        $this->file_columns = ['image'];
        $this->translated_file_columns = [];
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
    public function my_store() {
        try {
            $model = $this->ModelRepository->all()->where('user_id', Auth::user()->id )->first();
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
    public function store(StoreStoreApiRequest $request) {
        try {
            $all = [];
            $all += ['user_id' =>  Auth::user()->id] ;

            $all += $this->store_files(
                $request,
                $this->folder_name,
                $this->file_columns
            );
            $except = ['user_id','image'];

            $model = $this->ModelRepository->create( Request()->except($except)+$all ) ;
            $model->user->assignRole('store');

            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( $model ) ],
                'Successful'               ,
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
    public function update(StoreUpdateApiRequest $request) {
        try {
            $old_model =  $this->ModelRepository->all()->where('user_id', Auth::user()->id )->first();
            $except = [];
            $all = $this->update_files(
                $old_model,
                $request,
                $this->folder_name,
                $this->file_columns
            );
            $except += ['user_id','image'];

            $this->ModelRepository->update($old_model->id,Request()->except($except)+$all) ;
            $model =  $this->ModelRepository->findById($old_model->id) ;

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
