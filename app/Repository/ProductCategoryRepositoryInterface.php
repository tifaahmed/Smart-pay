<?php

namespace App\Repository;

interface ProductCategoryRepositoryInterface extends EloquentRepositoryInterface{
    public function filterAll()  ;
    public function filterPaginate(int $itemsNumber)  ;
}
