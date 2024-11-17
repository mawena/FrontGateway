<?php

namespace App\Policies;

use App\Http\Traits\PermissionCheckerTrait;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use PermissionCheckerTrait;

	public function before(User $connectedUser, string $ability)
	{
		if ($connectedUser->profile == "admin") {
			return Response::allow();
		} else {
			foreach ($connectedUser->ability_rules as $ability_rule) {
				if ($ability_rule["subject"] == "all" && $ability_rule["action"] == "manage") {
					return Response::allow();
				}
			}
			return null;
		}
	}
	public function viewAny(User $connectedUser)
	{
		return $this->check(["read", "historical"], "user", $connectedUser) ? Response::allow() : Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}

	public function view(User $connectedUser, User $user)
	{
		return $this->check(["read"], "user", $connectedUser) ? Response::allow() : Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}

	public function create(User $connectedUser)
	{
		return $this->check(["create"], "user", $connectedUser) ? Response::allow() : Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}
	public function update(User $connectedUser)
	{
		return $this->check(["update"], "user", $connectedUser) ? Response::allow() : Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}
	public function update_password(User $connectedUser)
	{
		return $this->check(["update-password"], "user", $connectedUser) ? Response::allow() : Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}
	public function delete(User $connectedUser)
	{
		return $this->check(["delete"], "user", $connectedUser) ? Response::allow() : Response::deny("Vous n'êtes pas autorisé à effectuer cette action");
	}
}
