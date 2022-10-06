<?php

namespace App\Repository;

interface ProductItemRepositoryInterface extends EloquentRepositoryInterface{
    public function sync_product_extra(int $id,array $product_extra_ids = [])  ;
}
