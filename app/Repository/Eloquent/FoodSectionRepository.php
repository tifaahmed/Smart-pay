<?php

namespace App\Repository\Eloquent;

use App\Models\FoodSection as ModelName;
use App\Repository\FoodSectionRepositoryInterface;

class FoodSectionRepository extends BaseRepository implements FoodSectionRepositoryInterface
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