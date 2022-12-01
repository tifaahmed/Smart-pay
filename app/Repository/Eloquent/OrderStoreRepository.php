<?php

namespace App\Repository\Eloquent;

use App\Models\OrderStore as ModelName;
use App\Repository\OrderStoreRepositoryInterface;

class  OrderStoreRepository extends BaseRepository implements OrderStoreRepositoryInterface
{
	protected $model;

	public function __construct(ModelName $model)
	{
		$this->model =  $model;
	}

	// * @param  integer    $order_id 
	// * @param  object     $store_model  
	// * @param  object    $coupon_model 
	// create the basec data
	public function custome_create($order_id,$store_model,$coupon_model = null){
		$store_delevery_fee = $store_model->delevery_fee ?? 0 ;


		$order_store_data = [];
		// ralation to the parent
		$order_store_data['order_id'] = $order_id;

		// store data
		$order_store_data['store_id'] = $store_model->id; // will not delete if store deleted
		$order_store_data['store_title'] = $store_model->title;

		// can be nul if there is no coupon used
		$order_store_data['coupon_title'] = $coupon_model ? $coupon_model->title : null;
		$order_store_data['coupon_code'] = $coupon_model ? $coupon_model->code : null;
		$order_store_data['coupon_discount_type'] = $coupon_model ? $coupon_model->type : null;
		

		$order_store_data['delevery_fee'] = $store_delevery_fee; // ,delevery fee from single stores
		

		return  $this->create( $order_store_data ) ;

	}

}