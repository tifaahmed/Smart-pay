<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;

// Resource
use App\Http\Resources\Dashboard\Collections\OrderCollection as ModelCollection;
use App\Http\Resources\Dashboard\Order\OrderResource as ModelResource;
// lInterfaces
use App\Repository\OrderRepositoryInterface as ModelInterface;

// Requests
use App\Http\Requests\Api\Dashboard\Order\OrderStoreApiRequest as modelInsertRequest;
use App\Http\Requests\Api\Dashboard\Order\OrderUpdateApiRequest as modelUpdateRequest;

class OrderController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->folder_name = 'order/'.date('Y-m-d-h-i-s');
        $this->file_columns = [];
        $this->translated_file_columns = [];
        $this->default_per_page = 10;
    }
    
    public function all(){
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

    public function store(modelInsertRequest $request) {
        try {
            $except = [];
            $all = [];
            if ($this->file_columns) {
                $all += $this->store_files(
                    $request,
                    $this->folder_name,
                    $this->file_columns
                );
                $except += $this->file_columns;
            }
            if ($this->translated_file_columns) {
                $all += $this->store_translated_files(
                    $request,
                    $this->folder_name,
                    $this->translated_file_columns
                );
                $except += $this->translated_file_columns;
            }
            $model = $this->ModelRepository->create( Request()->except($except)+$all ) ;
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
    public function update(modelUpdateRequest $request ,$id) {
        try {
            $old_model =  $this->ModelRepository->findById($id)  ;
            $all = $this->update_files(
                $old_model,
                $request,
                $this->folder_name,
                $this->file_columns
            );

            $this->ModelRepository->update( $id,Request()->except($this->file_columns)+$all) ;
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

    public function destroy($id) {
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

    
    // trash functions
    public function collection_trash(Request $request){
        try {
            $modal = $this->ModelRepository->collection_trash(  $request->per_page = $this->default_per_page );
            return new ModelCollection ( $modal  ) ;
        } catch (\Exception $e) {
            return $this -> MakeResponseErrors(  
                [$e->getMessage()  ] ,
                'Errors',
                Response::HTTP_NOT_FOUND
            );
        }
    }
    public function show_trash($id) {
        try {
            $modal = $this->ModelRepository->findTrashedById($id);
            return $this -> MakeResponseSuccessful( 
                [new ModelResource ( $modal )  ],
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
    public function premanently_delete($id) {
        try {
            $model =  $this->ModelRepository->findTrashedById($id) ;

            if (count($this->translated_file_columns)) {
                $this->deleteAlltranslatableFiles($model,$this->translated_file_columns);
            }
            if (count($this->file_columns)) {
                $this->deleteAllFiles($model,$this->file_columns);
            }
            
            $this->ModelRepository->PremanentlyDeleteById($id);
            return $this -> MakeResponseSuccessful( 
                [$model] ,
                'Successful'               ,
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
    public function restore($id) {
        try {
            return $this -> MakeResponseSuccessful( 
                [ $this->ModelRepository->restorById($id)  ],
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
    // trash functions
}

