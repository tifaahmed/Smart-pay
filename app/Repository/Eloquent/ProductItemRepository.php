<?php

namespace App\Repository\Eloquent;

use App\Models\ProductItem as ModelName;
use App\Repository\ProductItemRepositoryInterface;

class ProductItemRepository extends BaseRepository implements ProductItemRepositoryInterface
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

	public function sync_product_extra(int $id,array $product_extra_ids = []) 
    {
		$result = $this->findById($id); 
		$result->product_extras()->sync($product_extra_ids);
		return 'success';
	}
}