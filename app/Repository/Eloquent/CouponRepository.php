<?php

namespace App\Repository\Eloquent;

use App\Models\Coupon as ModelName;
use App\Repository\CouponRepositoryInterface;

class  CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
	public function __construct(ModelName $model)
	{
		$this->model =  $model;
	}

	public function findByCode($code) {
		return $this->model->where('code',$code)->first();
	}


}