<?php

namespace App\Repository\Eloquent;

use App\Models\OrderItem as ModelName;
use App\Repository\OrderItemRepositoryInterface;

class  OrderItemRepository extends BaseRepository implements OrderItemRepositoryInterface
{
	public function __construct(ModelName $model)
	{
		$this->model =  $model;
	}
    public function custome_update($order_item_model_id,$order_item_extra_sub_totals,$order_item_sub_total){
		$order_item_extra_sub_totals = $order_item_extra_sub_totals;
		$sub_total = $order_item_sub_total;
		

	}


	public function custome_create($store_id,$cart){
		
		$order_store_id = $store_id;

		$product_id 		= $cart->id;
		$product_title 		= $cart->product_title;
		$product_price 		= $cart->product_price;
		$product_offer 		= $cart->product_discount;
		$product_quantity 	= $cart->quantity;

		
		$order_item_data = [];
		
		// ralation parent
			$order_item_data['order_store_id'] = $order_store_id;

		// product info 
			$order_item_data['product_id']    = $product_id;   // will not delete if store deleted
			$order_item_data['product_title'] = $product_title;
			$order_item_data['product_price'] = $product_price; // pure price
			$order_item_data['product_offer'] = $product_offer; // enum , 0%,10%,5%,15%,20% product offer
			$order_item_data['product_quantity'] = $product_quantity;

		return  $this->create( $order_item_data ) ;

	}

}