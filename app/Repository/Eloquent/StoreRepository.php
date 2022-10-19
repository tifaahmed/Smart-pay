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

    public function filter($filter){
		$keyName= $this->model->getKeyName() ;
		$fillable= $this->model->getFillable() ;
		array_push($fillable,$keyName);
 
		$result = QueryBuilder::for($this->model);

		$result = $result->allowedFilters($fillable);
		$result = $result->allowedFilters(AllowedFilter::scope('FreeDelevery') )	;
		$result = $result->allowedFilters(AllowedFilter::scope('Offer') )	;
		$result = $result->allowedFilters(AllowedFilter::scope("Nearest") )		;
		$result = $result->allowedFilters(AllowedFilter::scope("food_section") )		;

		if ( isset($filter) && $filter['Nearest'] ) {
			$result = $result->orderby("distance", "desc") ;
		}else{
			$result = $result->latest('id');
		}

		return $result;
	}

    public function filterPaginate($filter,int $itemsNumber){
		$result =  $this->filter($filter);
		return $result->paginate($itemsNumber)->appends(request()->query());
		
	}
	public function filterAll($filter)  {
		$result =  $this->filter($filter);
		return $result ->get();
	}


	public function sync_food_section(int $id,array $food_section_ids = []) 
    {
		$result = $this->findById($id); 
		$result->food_sections()->sync($food_section_ids);
		return 'success';
	}
	

}