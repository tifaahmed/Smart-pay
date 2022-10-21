<?php

namespace App\Repository;

interface OrderStoreRepositoryInterface extends EloquentRepositoryInterface{
    public function custome_create($order_id,$store_model,$coupon_model);
    public function custome_update($order_store_model,$discount_number)  ;
}
