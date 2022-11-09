<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Auth;

// Resource
use App\Http\Resources\Mobile\User\UserResource as ModelResource;

// Requests
use App\Http\Requests\Api\Mobile\User\UserUpdateApiRequest as modelUpdateRequest;

// lInterfaces
use App\Repository\UserRepositoryInterface as ModelInterface;

class UserController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->folder_name = 'user/'.date('Y-m-d-h-i-s');
        $this->file_columns = ['avatar'];
    }


    public function show() {
        try {
            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( Auth::user() ) ],
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
    public function update(modelUpdateRequest $request) {
        try {
            $except_array = ['phone_verified_at','email_verified_at'] ;
            $all  = [] ;

            $old_model =  $this->ModelRepository->findById(Auth::user()->id)  ;
            if ($request->phone && $old_model != $request->phone) {
                $all['phone_verified_at'] = null ;
            }
            if ($request->email && $old_model != $request->email) {
                $all['email_verified_at'] = null ;
            }
            if (count($this->file_columns) > 0) {
                $except_array += $this->file_columns;
                $all += $this->update_files(
                    $old_model,
                    $request,
                    $this->folder_name,
                    $this->file_columns
                );
            }
            $this->ModelRepository->update(Auth::user()->id,Request()->except($except_array)+$all) ;

 
            return $this -> MakeResponseSuccessful( 
                [ new ModelResource ( Auth::user() ) ],
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
