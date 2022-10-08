<?php

namespace App\Repository\Eloquent;

use App\Models\OrderItem as ModelName;
use App\Repository\OrderItemRepositoryInterface;

class  OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
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