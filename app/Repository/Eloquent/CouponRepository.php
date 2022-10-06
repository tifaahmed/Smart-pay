<?php

namespace App\Repository\Eloquent;

use App\Models\Coupon as ModelName;
use App\Repository\CouponRepositoryInterface;

class  CouponRepository extends BaseRepository implements CouponRepositoryInterface
{

	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * BaseRepository  constructor
	 * @param  Model $model
	 */
	public function __construct(ModelName $model)
	{
		$this->model =  $model;
	}
}