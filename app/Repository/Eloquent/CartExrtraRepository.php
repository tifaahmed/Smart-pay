<?php

namespace App\Repository\Eloquent;

use App\Models\CartExtra as ModelName;
use App\Repository\CartExrtraRepositoryInterface;

class  CartExrtraRepository extends BaseRepository implements CartExrtraRepositoryInterface
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