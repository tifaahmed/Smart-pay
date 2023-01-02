<?php

namespace App\Repository\Eloquent;

use App\Models\Address as ModelName;
use App\Repository\AddressRepositoryInterface;

class  AddressRepository extends BaseRepository implements AddressRepositoryInterface
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