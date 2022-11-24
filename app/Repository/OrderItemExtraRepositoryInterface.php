<?php

namespace App\Repository;

interface OrderItemExtraRepositoryInterface extends EloquentRepositoryInterface{
    public function custome_create($order_item_id,$cart_extra);

}
