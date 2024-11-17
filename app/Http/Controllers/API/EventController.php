<?php

namespace App\Http\Controllers\API;

use App\Http\Traits\CustomResponseTrait;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
	public function index(Request $request)
	{
		$requestData = $request->all();
		if (!($authorisation = Gate::inspect('viewAny', Event::class))->allowed()) {
			return $this->responseError(["auth" => [$authorisation->message()]], 403);
		}
		$list = Event::query();
		$list = $this->queryFilter($list, $requestData, "User");
		$list = $this->queryRelationAdd($list, $requestData, "User");
		($search = $request->search) ? $list = $this->querySearch($list, ["name"], $search) : null;
		return $this->responseIndexOk($list, $requestData, "User");
	}

	public function show(Request $request, $id)
	{
		if (!($authorisation = Gate::inspect('view', Event::class))->allowed()) {
			return $this->responseError(["auth" => [$authorisation->message()]], 403);
		}
		$model = Event::find($id);
		if ($model == null) {
			return ["status" => 404, "message" => "L'evenement n'existe pas"];
		}
		return ["status" => 200, "Event" => $model];
	}

	public function store(Request $request)
	{
		$requestData = $request->all();
		if (!($authorisation = Gate::inspect('create', Event::class))->allowed()) {
			return $this->responseError(["auth" => [$authorisation->message()]], 403);
		}
		$validator = Validator($requestData, [
			"name" => "required | min:2",
			"description" => "required",
			"start_date" => "required"
		]);
		if ($validator->fails()) {
			return $this->responseError($validator->errors()->toArray());
		}
		$model = Event::Create($requestData);
		return ["status" => 201, "Event" => $model];
	}

	public function update(Request $request, $id)
	{
		$model = Event::find($id);
		if (!$model) {
			return $this->responseError(["id" => ["l'evenement n'a pas été trouvé"]]);
		}
		$requestData = $request->all();
		if (!($authorisation = Gate::inspect('update', Event::class))->allowed()) {
			return $this->responseError(["auth" => [$authorisation->message()]], 403);
		}
		$validator = validator($requestData, [
			"name" => "required | min:2",
			"description" => "required",
			"start_date" => "required"
		]);
		if ($validator->fails()) {
			return $this->responseError($validator->errors()->toArray());
		}
		$model->update($requestData);
		return ["status" => 200, "" => $model];
	}

	public function destroy(Request $request, $id)
	{
		if (!($authorisation = Gate::inspect('view', Event::class))->allowed()) {
			return $this->responseError(["auth" => [$authorisation->message()]], 403);
		}
		$model = Event::find();
		if ($model == null) {
			return ["status" => 404, "message" => "l'evenement n'a pas été retrouvé"];
		}
		$model->delete();
		return ["status" => 200, "message" => "la plateforme a été supprimé avec succès"];
	}
}
