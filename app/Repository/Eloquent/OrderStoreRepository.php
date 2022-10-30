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
    public function custome_update($order_store_model,$discount_number){
		$order_item_sub_totals = $order_store_model->order_items->sum('sub_total');
		
		$after_discount  = $order_item_sub_totals - $discount_number ;
		$after_discount = $after_discount < 0 ? 0 : $after_discount;
		$sub_total = $after_discount + $order_store_model->delevery_fee  ;

		$this->update($order_store_model->id ,[
			'coupon_discount'=>$discount_number ,
			'order_item_sub_totals'=>$order_item_sub_totals ,
			'sub_total'=>  $sub_total
		]);
	}

	public function custome_create($order_id,$store_model,$coupon_model){
		$coupon_discount = 0;
		$order_item_sub_totals = 0;
		$sub_total = 0 ;
		
		$order_store_data = [];

		$order_store_data['order_id'] = $order_id;
		$order_store_data['store_id'] = $store_model->id; // will not delete if store deleted

		$order_store_data['store_title'] = $store_model->title;

		$order_store_data['coupon_title'] = $coupon_model ? $coupon_model->title : null;
		$order_store_data['coupon_code'] = $coupon_model ? $coupon_model->code : null;
		$order_store_data['coupon_discount_type'] = $coupon_model ? $coupon_model->type : null;
		
		$order_store_data['delevery_fee'] = $store_model->delevery_fee; // ,delevery fee from single stores
		
		$order_store_data['coupon_discount'] = $coupon_discount; // order_item_sub_totals - discount
		$order_store_data['order_item_sub_totals'] = $order_item_sub_totals; //,collect sub_total of table order_items
		$order_store_data['sub_total'] = $sub_total; //  (order_item_sub_totals + delevery_fee ) - coupon_discount 

		return  $this->create( $order_store_data ) ;

	}

}