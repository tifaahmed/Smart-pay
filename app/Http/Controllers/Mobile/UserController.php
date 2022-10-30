<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;
use Auth;

// Resource
use App\Http\Resources\Mobile\Collections\UserCollection as ModelCollection;
use App\Http\Resources\Mobile\User\UserResource as ModelResource;

// lInterfaces
use App\Repository\UserRepositoryInterface as ModelInterface;

class UserController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->default_per_page = 10;
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

}
