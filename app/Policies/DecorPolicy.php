<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class DecorPolicy extends BasePolicy
{
	protected $modelName = "decor";

	public function update(User $connectedUser, Model $decor)
	{
		if ($this->check(["update"], $this->modelName, $connectedUser)){
			if ($decor->event->user_id == $connectedUser->id){
				return Response::allow();
			}
		}
		return  Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}
	public function delete(User $connectedUser, Model $decor){
		if ($this->check(["delete"], $this->modelName, $connectedUser)){
			if ($decor->event->user_id == $connectedUser->id){
				return Response::allow();
			}
		}
		return  Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}
}
