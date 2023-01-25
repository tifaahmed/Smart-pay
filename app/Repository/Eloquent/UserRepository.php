<?php

namespace App\Repository\Eloquent;

use App\Models\User as ModelName;
use App\Repository\UserRepositoryInterface;
use Spatie\Permission\Models\Role;

class UserRepository extends BaseRepository implements UserRepositoryInterface
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

	public function attachRole($role_ids,$id){
        if($role_ids){
            $user = $this->findById($id); 
            $role_names = Role::whereIn('id',$role_ids)->pluck('name')->toArray();
            $user->syncRoles($role_names);
        }
    }
}