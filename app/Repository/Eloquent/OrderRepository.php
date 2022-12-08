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

	// create the basec data
	public function custome_create($payment_type,$site_fee)   {
		$user_id = Auth::user()->id;

		$payment_type = $payment_type;
		$payment_card_status  = $payment_type == 'visa' ? 'pindding' : null;

		$order_code =  rand(1111111111, 9999999999).time();
		$site_fee =  $site_fee;
		
		$order_data = [];
		$order_data['user_id'] = $user_id;

		$order_data['payment_type'] =  $payment_type; //  [ 'visa','cash'] , default('cash')
		$order_data['payment_card_status'] = $payment_card_status; // [ 'paid','pending'] , nullable

		$order_data['order_code'] = $order_code; // unique

		$order_data['site_fee'] = $site_fee; // unique
		
		return  $this->create( $order_data ) ;

	}
}