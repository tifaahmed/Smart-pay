<?php

namespace App\Repository\Eloquent;

use App\Models\Extra as ModelName;
use App\Repository\ExtraRepositoryInterface;

class  ExtraRepository extends BaseRepository implements ExtraRepositoryInterface
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