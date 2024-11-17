<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class EventPolicy extends BasePolicy
{
	protected $modelName = "event";

	public function update(User $connectedUser, Model $event)
	{
		if ($this->check(["update"], $this->modelName, $connectedUser)){
			if ($event->user_id == $connectedUser->id){
				return Response::allow();
			}
		}
		return  Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}
	public function delete(User $connectedUser, Model $event){
		if ($this->check(["delete"], $this->modelName, $connectedUser)){
			if ($event->user_id == $connectedUser->id){
				return Response::allow();
			}
		}
		return  Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}
}
