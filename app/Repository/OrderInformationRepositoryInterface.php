<?php

namespace App\Repository;

interface OrderInformationRepositoryInterface extends EloquentRepositoryInterface{
    public function custome_create($order_id,$address_modal);

}
