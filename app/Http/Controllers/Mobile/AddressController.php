<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Auth ;

// Resource
use App\Http\Resources\Mobile\Collections\AddressCollection as ModelCollection;
use App\Http\Resources\Mobile\Address\AddressResource as ModelResource;
// lInterfaces
use App\Repository\AddressRepositoryInterface as ModelInterface;

// Requests
use App\Http\Requests\Api\Mobile\Address\AddressStoreApiRequest as modelInsertRequest;
use App\Http\Requests\Api\Mobile\Address\AddressUpdateApiRequest as modelUpdateRequest;
use App\Http\Requests\Api\Mobile\Address\AddressRelatedApiRequest as modeRelatedRequest;

class AddressController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->folder_name = 'address/'.date('Y-m-d-h-i-s');
        $this->file_columns = [];
        $this->translated_file_columns = [];
        $this->default_per_page = 10;
    }
    
    public function all(Request $request){
        try {
             $modal =    $this->ModelRepository->all();
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
            $all = $request->validated();
            if ($this->file_columns) {
                $all += $this->store_files(
                    $request,
                    $this->folder_name,
                    $this->file_columns
                );
            }
            if ($this->translated_file_columns) {
                $all += $this->store_translated_files(
                    $request,
                    $this->folder_name,
                    $this->translated_file_columns
                );
            }
            $all['user_id'] = Auth::user()->id;
            $all['city_name'] = ''; //by Mutator
            $model = $this->ModelRepository->create( $all ) ;
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
             $old_model =  $this->ModelRepository->findById($id);

            $all = $request->all();
            if ($this->file_columns) {
                $all += $this->update_files(
                    $old_model,
                    $request,
                    $this->folder_name,
                    $this->file_columns
                );
            }
            if ($this->translated_file_columns) {
                $all += $this->update_translated_files(
                    $old_model,
                    $request,
                    $this->folder_name,
                    $this->translated_file_columns
                );
            }
            $this->ModelRepository->update( $old_model->id,$all) ;
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

    public function show(modeRelatedRequest $request,$id) {
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

    public function destroy(modeRelatedRequest $request, $id) {
        try {
            $this->ModelRepository->deleteById($id);
            return $this -> MakeResponseSuccessful( 
                [ 'deleted'],
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
