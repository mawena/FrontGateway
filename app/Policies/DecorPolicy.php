<?php

namespace App\Policies;

use App\Http\Traits\PermissionCheckerTrait;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DecorPolicy extends BasePolicy
{
	protected $modelName = "decor";
}
