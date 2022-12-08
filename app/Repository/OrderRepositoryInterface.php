<?php

namespace App\Repository;

interface OrderRepositoryInterface extends EloquentRepositoryInterface{
    public function custome_create($payment_type,$site_fee)  ;

}
