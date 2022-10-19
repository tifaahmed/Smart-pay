<?php

namespace App\Repository\Eloquent;

use App\Models\OrderInformation as ModelName;
use App\Repository\OrderInformationRepositoryInterface;
use  Auth;
class  OrderInformationRepository extends BaseRepository implements OrderInformationRepositoryInterface
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

	public function custome_create($order_id,$address_modal){
		$user_modal = Auth::user();

		$city_modal = $address_modal->city;

		$user_full_name = $user_modal->full_name; // get Attribute
		$phone = $user_modal->phone; 

		$address = $address_modal->address;  
		$department = $address_modal->department;  
		$house = $address_modal->house;  
		$street = $address_modal->street;  
		$note = $address_modal->note; 
		$type = $address_modal->type; 

		$city_id = $city_modal->id; 
		$city_name = $city_modal->name; 
		$latitude = $address_modal->latitude; 
		$longitude = $address_modal->longitude;  


		$order_information_data = [];
		$order_information_data['order_id'] = $order_id;
		$order_information_data['user_full_name'] = $user_full_name;
		$order_information_data['phone'] = $phone;
		$order_information_data['address'] = $address;
		$order_information_data['department'] = $department;
		$order_information_data['house'] = $house;
		$order_information_data['street'] = $street;
		$order_information_data['note'] = $note;
		$order_information_data['type'] = $type;
		$order_information_data['city_id'] = $city_id;
		$order_information_data['city_name'] = $city_name;
		$order_information_data['latitude'] = $latitude;
		$order_information_data['longitude'] = $longitude;

		return  $this->create( $order_information_data ) ;

	}

}