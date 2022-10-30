<?php

namespace App\Repository\Eloquent;

use App\Models\ExtraCategory as ModelName;
use App\Repository\ExtraCategoryRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
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

	public function filter(){
		$keyName= $this->model->getKeyName() ;
		$fillable= $this->model->getFillable() ;
		array_push($fillable,$keyName);
 
		$result = QueryBuilder::for($this->model);

		$result = $result->allowedFilters($fillable);
		$result = $result->allowedFilters(AllowedFilter::scope('product_filter') )	;

		return $result;
	}

    public function filterPaginate(int $itemsNumber){
		$result =  $this->filter();
		$result = $result->latest('id');
		return $result->paginate($itemsNumber)->appends(request()->query());
		
	}
	public function filterAll()  {
		$result =  $this->filter();
		return $result ->get();
	}
}