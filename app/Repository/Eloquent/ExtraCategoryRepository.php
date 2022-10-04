<?php

namespace App\Repository\Eloquent;

use App\Models\ExtraCategory as ModelName;
use App\Repository\ExtraCategoryRepositoryInterface;

class  ExtraCategoryRepository extends BaseRepository implements ExtraCategoryRepositoryInterface
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