<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;

use App\Repository\OrderStoreRepositoryInterface as ModelInterface;

class OrderStoreController extends Controller
{
    private $Repository;
    public function __construct(ModelInterface $Repository)
    {
        $this->ModelRepository = $Repository;
        $this->default_per_page = 10;
    }
}
