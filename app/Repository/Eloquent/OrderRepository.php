<?php

namespace App\Repository\Eloquent;

use App\Models\Order as ModelName;
use App\Repository\OrderRepositoryInterface;
use Auth;

class  OrderRepository extends BaseRepository implements OrderRepositoryInterface
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

	public function custome_create($payment_type){
		$order_status = 'not_confirmed';
		$payment_type = $payment_type;
		$payment_card_status  = $payment_type == 'visa' ? 'pindding' : null;
		$user_id = Auth::user()->id;

		$order_data = [];
		$order_data['user_id'] = $user_id;

		$order_data['order_status'] =  $order_status ;
		$order_data['payment_type'] =  $payment_type;
		$order_data['payment_card_status'] = $payment_card_status;


		$order_data['order_store_sub_totals'] = 0;
		$order_data['site_fee'] = 0;
		$order_data['total'] = 0;
		
		return  $this->create( $order_data ) ;

	}
}