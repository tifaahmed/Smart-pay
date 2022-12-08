<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;
use Illuminate\Support\Str;

// Resource
use App\Http\Resources\Mobile\Collections\SubscriptionCollection as ModelCollection;
use App\Http\Resources\Mobile\Subscription\SubscriptionResource as ModelResource;

// lInterfaces
use App\Repository\SubscriptionRepositoryInterface as ModelInterface;

// Requests
use App\Http\Requests\Api\Mobile\Subscription\SubscriptionStoreApiRequest as modelInsertRequest;
use App\Http\Requests\Api\Mobile\Subscription\SubscriptionUpdateApiRequest as modelUpdateRequest;

class SubscriptionController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->folder_name = 'Subscription/'.date('Y-m-d-h-i-s');
        $this->file_columns = [];
        $this->translated_file_columns = [];
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
}
