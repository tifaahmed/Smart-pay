<?php

namespace App\Repository\Eloquent;

use App\Models\OrderItemExtra as ModelName;
use App\Repository\OrderItemExtraRepositoryInterface;

class  OrderItemExtraRepository extends BaseRepository implements OrderItemExtraRepositoryInterface
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
	public function custome_create($order_item_id,$cart_extra){
		$extra_id =  $cart_extra->id;
		$extra_title =  $cart_extra->extra_title;
		$extra_price =  $cart_extra->extra_price;
		
		$sub_total =  $extra_price ;
		
		$order_item_extra_data['order_item_id'] = $order_item_id;
		$order_item_extra_data['extra_id'] = $extra_id;   // will not delete if extra deleted
		$order_item_extra_data['extra_title'] = $extra_title;
		$order_item_extra_data['extra_price'] = $extra_price;
		
		$order_item_extra_data['sub_total'] = $sub_total;

		return  $this->create( $order_item_extra_data ) ;
	}

}