<?php

namespace App\Repository;

interface ExtraCategoryRepositoryInterface extends EloquentRepositoryInterface{
    public function filterAll()  ;
    public function filterPaginate(int $itemsNumber)  ;
}
