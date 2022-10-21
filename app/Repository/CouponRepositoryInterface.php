<?php

namespace App\Repository;

interface CouponRepositoryInterface extends EloquentRepositoryInterface{
    public function findByCode($code)  ;
}
