<?php

namespace App\Repository;

interface OrderItemRepositoryInterface extends EloquentRepositoryInterface{
    public function custome_create($store_id,$cart)  ;
    public function custome_update($order_item_model_id,$order_item_extra_sub_totals,$order_item_sub_total)  ;

}
