<?php

namespace App\Repository\Eloquent;

use App\Models\OrderItem as ModelName;
use App\Repository\OrderItemRepositoryInterface;

class  OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
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

	public function custome_create($store_id,$product_model,$quantity){
		
		$order_store_id = $store_id;

		$product_id = $product_model->id;
		$product_title = $product_model->title;
		$product_price = $product_model->price;
		$product_offer = $product_model->discount;

		$quantity = $quantity ;

		$order_item_extra_sub_totals = 0;
		
		
		$product_price_after_offer =  - ( ($product_price * $product_offer/100) ) + $product_price ;
		$sub_total = $product_price_after_offer * $quantity;


		$order_item_data = [];
		$order_item_data['order_store_id'] = $order_store_id;

		$order_item_data['product_id'] = $product_id;   // will not delete if store deleted
		$order_item_data['product_title'] = $product_title;
		$order_item_data['product_price'] = $product_price; // pure price
		$order_item_data['product_offer'] = $product_offer; // enum , 0%,10%,5%,15%,20% product offer
		
		$order_item_data['quantity'] = $quantity;

		$order_item_data['order_item_extra_sub_totals'] = $order_item_extra_sub_totals; // collect sub_total of table order_item_extras
		$order_item_data['sub_total'] = $sub_total; // (product_price after offer  * quantity ) + order_item_extra_sub_totals


		return  $this->create( $order_item_data ) ;

	}

}