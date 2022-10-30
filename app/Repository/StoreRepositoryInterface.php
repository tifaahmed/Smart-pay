<?php

namespace App\Repository;

interface StoreRepositoryInterface extends EloquentRepositoryInterface{
	public function filterAll($filter)  ;
    public function filterPaginate($filter,int $itemsNumber)  ;
    public function sync_food_section(int $id,array $food_section_ids = [])  ;
}
