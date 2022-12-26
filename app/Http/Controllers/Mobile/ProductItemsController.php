<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

// Resource
use App\Http\Resources\Mobile\Collections\ProductItemCollection as ModelCollection;
use App\Http\Resources\Mobile\ProductItem\ProductItemResource as ModelResource;

// lInterfaces
use App\Repository\ProductItemRepositoryInterface as ModelInterface;

// Requests
use App\Http\Requests\Api\Mobile\ProductItem\ProductItemStoreApiRequest as modelInsertRequest;
use App\Http\Requests\Api\Mobile\ProductItem\ProductItemUpdateApiRequest as modelUpdateRequest;
use App\Http\Requests\Api\Mobile\ProductItem\ProductItemFavApiRequest ;

class ProductItemsController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->folder_name = 'product-item/'.date('Y-m-d-h-i-s');
        $this->file_columns = ['image'];
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
            $all['store_id'] = Auth::user()->id;
            $all['status'] = 'request_as_new';
            
            $model = $this->ModelRepository->create( $all ) ;
            
            // product_extras
            $this->ModelRepository->sync_product_extra($model->id,$request->product_extra_ids ?? []);

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
            return $all = $request->validated();
            $all += $this->update_files(
                $old_model,
                $request,
                $this->folder_name,
                $this->file_columns
            );
            $all['status'] = 'request_as_edit';

            $this->ModelRepository->update( $id,$all) ;
            $model =  $this->ModelRepository->findById($id) ;
            
            // product_extras
            $this->ModelRepository->sync_product_extra($model->id,$request->product_extra_ids ?? []);

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
    public function fav_toggle(ProductItemFavApiRequest $request) {
        try {
            $model = $this->ModelRepository->findById($request->product_id);
            $model->fav_products()->toggle(Auth::user()->id);

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
