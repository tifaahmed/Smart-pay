<?php

namespace App\Repository;

interface StoreRepositoryInterface extends EloquentRepositoryInterface{
    public function sync_food_section(int $id,array $food_section_ids = [])  ;
}
