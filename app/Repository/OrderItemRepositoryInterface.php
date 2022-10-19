<?php

namespace App\Repository;

interface OrderItemRepositoryInterface extends EloquentRepositoryInterface{
    public function custome_create($store_id,$product_model,$quantity)  ;

}
