<?php

namespace App\Repository\Eloquent;

use App\Models\AboutUs as ModelName;
use App\Repository\AboutUsRepositoryInterface;

class  AboutUsRepository extends BaseRepository implements AboutUsRepositoryInterface
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