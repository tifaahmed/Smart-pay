<?php

namespace App\Repository;

interface OrderItemRepositoryInterface extends EloquentRepositoryInterface{
    public function custome_create($store_id,$cart)  ;
    public function custome_update($order_item_model)  ;

}
