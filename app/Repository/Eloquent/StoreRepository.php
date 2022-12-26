<?php

namespace App\Repository\Eloquent;

use App\Models\Store as ModelName;
use App\Repository\StoreRepositoryInterface;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class StoreRepository extends BaseRepository implements StoreRepositoryInterface
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



	public function sync_food_section(int $id,array $food_section_ids = []) 
    {
		$result = $this->findById($id); 
		$result->food_sections()->sync($food_section_ids);
		return 'success';
	}
	

}