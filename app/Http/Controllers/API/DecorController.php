<?php

namespace App\Http\Controllers\API;

use App\Models\Decor;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

/**
 * @group Decors
 *
 * EndPoints pour gérer les décors
 */
class DecorController extends Controller
{
    /**
	 * Affiche les decors
	 *
	 * @queryParam  name										string			Filtrer par nom du decor.													 No-example
	 * @queryParam  file_path									string			Filtrer par chemin du decor.												 No-example
	 * @queryParam  event_id									string			Filtrer par événement.														 No-example
	 * 
	 * @queryParam  with_event									string			Afficher l'événement.														Example: false
	 * 
	 * @queryParam  paginate									string			Utiliser la pagination.														Example: false
	 *
	 * @response 200
	 */
	public function index(Request $request)
	{
		if (($authorisation = Gate::inspect('viewAny', Decor::class))->allowed()) {
			$list = Decor::query();

			$requestData = $request->all();
			($search = $request->search) ? $list = $this->querySearch($list, ["name", "dedecorion"], $search) : null;
			$list = $this->queryFilter($list, $requestData, "Decor");
			$list = $this->queryRelationAdd($list, $requestData, "Decor");

			return $this->responseIndexOk($list, $requestData, "Decor");
		} else {
			return $this->responseError(["auth" => [$authorisation->message()]], 403);
		}
	}


	/**
	 * Affiche un décor
	 *
	 * @urlParam	id											integer			L'ID du decor.																Example: 1.
	 *
	 * @queryParam  with_event									string			Afficher l'événement.														Example: false
	 * 
	 * @response 200
	 */
	public function show(Request $request, int $id)
	{
		$model = Decor::find($id);
		$requestData = $request->all();
		if ($model) {
			if (($authorisation = Gate::inspect('view', $model))->allowed()) {
				$model = $this->modelRelationLoad($model, $requestData, "Decor");
				return $this->responseOk(["decor" => $model]);
			} else {
				return $this->responseError(["auth" => [$authorisation->message()]], 403);
			}
		} else {
			return $this->responseError(["id" => "Le decor n'existe pas"], 404);
		}
	}

	/**
	 * Créer un nouveau decor
	 *
	 * @bodyParam	name										string			  	Le nom du decor.														Example: first
	 * @bodyParam	file										string			  	Le fichier.																Example: ...
	 * @bodyParam	description									string			  	La description.															Example: ...
	 * @bodyParam	event_id									integer			  	L'événement.															Example: 1
	 *
	 * @response 200
	 */
	public function store(Request $request)
	{
		return $this->modelStore(
			modelClass: "App\Models\Decor",
			requestData: $request->all(),
			validations: [
				"name" => "required|unique:decors",
				"file" => "required",
				"description" => "nullable",
				"event_id" => "required|exists:events:events:id",
			],
			manualValidations: function ($requestData) {
				$event = Event::get($requestData["event_id"]);
				if (!$this->checkIsBase64Validated($requestData["file"], ["png"])) {
					return ["errors" => $this->responseError(["file" => ["le fichier n'est pas une image valide"]], 400)];
				}
				if ($file_path = $this->saveImageFromBase64($requestData["file"], "pictures/decors/$event->id/" . Str::slug($requestData["name"]) . ".png")) {
					return ["data" => ["file_path" => $file_path]];
				} else {
					return ["errors" => $this->responseError(["file" => ["Une erreur est survenu durant l'insertion"]])];
				}
			},
			beforeCreate: function ($requestData, $data) {
				$requestData["file_path"] = $data["file_path"];
				return $requestData;
			},
		);
	}

	/**
	 * Mettre à jour un decor
	 *
	 * @urlParam	id											integer	required	L'ID du decor.															Example: 1
	 *
	 * @bodyParam	name										string			  	Le nom du decor.														Example: first
	 * @bodyParam	file										string			  	Le fichier.																Example: ...
	 * @bodyParam	description									string			  	La description.															Example: ...
	 * @bodyParam	event_id									integer			  	L'événement.															Example: 1
	 *
	 * @response 200
	 *
	 */
	public function update(Request $request, int $id)
	{
		return $this->modelUpdate(
			modelId: $id,
			modelClass: "App\Models\Decor",
			requestData: $request->all(),
			validations: [
				"name" => "required|unique:decors,name," . $id,
				"file" => "nullable|min:5",
				"description" => "nullable",
				"event_id" => "required|exists:events:events:id",
			],
			manualValidations: function ($requestData) {
				if (isset($requestData["file"])) {
					$event = Event::get($requestData["event_id"]);
					if (!$this->checkIsBase64Validated($requestData["file"], ["png"])) {
						return ["errors" => $this->responseError(["file" => ["le fichier n'est pas une image valide"]], 400)];
					}
					if ($file_path = $this->saveImageFromBase64($requestData["file"], "pictures/decors/$event->id/" . Str::slug($requestData["name"]) . ".png")) {
						return ["data" => ["file_path" => $file_path]];
					} else {
						return ["errors" => $this->responseError(["file" => ["Une erreur est survenu durant l'insertion"]])];
					}
				}
			},
			beforeUpdate: function ($model, $requestData, $data) {
				if (isset($data["file_path"])) {
					$requestData["file_path"] = $data["file_path"];
				}
				return $requestData;
			},
		);
	}
	
	/**
	 * Supprime un decor
	 *
	 * @urlParam	id											integer	required	L'ID du decor.														Example: 1
	 *
	 * @response 200
	 */
	public function destroy(int $id)
	{
		return $this->modelDelete(
			modelId: $id,
			modelClass: "App\Models\Decor",
		);
	}
}
