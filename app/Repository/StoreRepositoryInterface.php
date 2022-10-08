<?php

namespace App\Repository;

interface StoreRepositoryInterface extends EloquentRepositoryInterface{
	public function filterAll($filter)  ;
    public function filterPaginate($filter,int $itemsNumber)  ;
}
