<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;



/**
 * @group Evenements
 *
 * EndPoints pour gérer les événements
 */
class EventController extends Controller
{
	/**
	 * Affiche les événement
	 *
	 * @queryParam  name										string				Filtrer par nom.															 No-example
	 * @queryParam  start_date									string				Filtrer par date de début.													 No-example
	 * @queryParam  end_date									string				Filtrer par date de fin.													 No-example
	 * @queryParam  user_id										integer				Filtrer par promoteur.														 No-example
	 * 
	 * @queryParam  with_promoter								string				Afficher le promoteur.														Example: false
	 * 
	 * @queryParam  paginate									string				Utiliser la pagination.														Example: false
	 *
	 * @response 200
	 */
	public function index(Request $request)
	{
		$requestData = $request->all();
		if (!($authorisation = Gate::inspect('viewAny', Event::class))->allowed()) {
			return $this->responseError(["auth" => [$authorisation->message()]], 403);
		}

		$list = Event::query();
		($search = $request->search) ? $list = $this->querySearch($list, ["name", "start_date", "end_date"], $search) : null;
		$list = $this->queryFilter($list, $requestData, "Event");
		$list = $this->queryRelationAdd($list, $requestData, "Event");

		return $this->responseIndexOk($list, $requestData, "Event");
	}

	/**
	 * Affiche un décor
	 *
	 * @urlParam	id											integer				L'événement.																Example: 1.
	 *
	 * @queryParam  with_promoter								string				Afficher le promoteur.														Example: false
	 * 
	 * @response 200
	 */
	public function show(Request $request, $id)
	{
		$model = Event::find($id);
		$requestData = $request->all();
		if ($model) {
			if (($authorisation = Gate::inspect('view', $model))->allowed()) {
				$model = $this->modelRelationLoad($model, $requestData, "Event");
				return $this->responseOk(["user" => $model]);
			} else {
				return $this->responseError(["auth" => [$authorisation->message()]], 403);
			}
		} else {
			return $this->responseError(["id" => "l'element n'existe pas"], 404);
		}
	}

	/**
	 * Créer un nouveau decor
	 *
	 * @bodyParam  name											string					Le nom.																	Example: Hiver Togo
	 * @bodyParam  description									string					La description.															Example: Hiver Togo description
	 * @bodyParam  start_date									string					La date de début.														Example: 2024-12-01
	 * @bodyParam  end_date										string					La date de fin.															Example: 2025-01-01
	 * @bodyParam  picture										string					L'image.												 				Example: ...
	 *
	 * @response 200
	 */
	public function store(Request $request)
	{
		return $this->modelStore(
			modelClass: "App\Models\Event",
			requestData: $request->all(),
			validations: [
				"name" => "required|min:2",
				"description" => "nullable",
				"start_date" => "required|date",
				"end_date" => "nullable|date",
				"picture" => "nullable",
			],
			manualValidations: function ($requestData) {
				if (isset($requestData["picture"])) {
					if (!$this->checkIsBase64Validated($requestData["picture"], ["png", "jpeg", "jpg"])) {
						return ["errors" => $this->responseError(["picture" => ["le fichier n'est pas une image valide"]], 400)];
					}
					if ($picture_path = $this->saveImageFromBase64($requestData["picture"], "pictures/events/" . Str::slug($requestData["name"]) . ".png")) {
						return ["data" => ["picture_path" => $picture_path]];
					} else {
						return ["errors" => $this->responseError(["picture" => ["Une erreur est survenu durant l'insertion"]])];
					}
				}
			},
			beforeCreate: function ($requestData, $data) use ($request){
				$requestData["picture_path"] = isset($data["picture_path"]) ? $data["picture_path"] : "defaults/event.png";
				$requestData["user_id"] = $request->user()->id;
				return $requestData;
			},
			relations: ["with_promoter" => "true"]
		);
	}


	/**
	 * Mettre à jour un événement
	 *
	 * @urlParam	id											int	required			L'événement.															Example: 1
	 *
	 * @bodyParam  name											string					Le nom.																	Example: Hiver Togo
	 * @bodyParam  description									string					La description.															Example: Hiver Togo description
	 * @bodyParam  start_date									string					La date de début.														Example: 2024-12-01
	 * @bodyParam  end_date										string					La date de fin.															Example: 2025-01-01
	 * @bodyParam  picture										string					L'image.												 				Example: ...
	 *
	 * @response 200
	 *
	 */
	public function update(Request $request, $id)
	{
		return $this->modelUpdate(
			modelId: $id,
			modelClass: "App\Models\Event",
			requestData: $request->all(),
			validations: [
				"name" => "required|min:2",
				"description" => "nullable",
				"start_date" => "required|date",
				"end_date" => "nullable|date",
				"picture" => "nullable",
			],
			manualValidations: function ($requestData) {
				if (isset($requestData["picture"])) {
					if (!$this->checkIsBase64Validated($requestData["picture"], ["png", "jpeg", "jpg"])) {
						return ["errors" => $this->responseError(["picture" => ["le fichier n'est pas une image valide"]], 400)];
					}
					if ($picture_path = $this->saveImageFromBase64($requestData["picture"], "pictures/events/" . Str::slug($requestData["name"]) . ".png")) {
						return ["data" => ["picture_path" => $picture_path]];
					} else {
						return ["errors" => $this->responseError(["picture" => ["Une erreur est survenu durant l'insertion"]])];
					}
				}
			},
			beforeUpdate: function ($model, $requestData, $data) {
				if(isset($data["picture_path"])){
					$requestData["picture_path"] = $data["picture_path"];
				}else{
					unset($requestData["picture_path"]);
				}

				return $requestData;
			},
			relations: ["with_promoter" => "true"]
		);
	}

	/**
	 * Supprime un événement
	 *
	 * @urlParam	id											int required			L'ID de l'utilisateur.													Example: 1
	 *
	 * @response 200
	 */
	public function destroy(Request $request, $id)
	{
		return $this->modelDelete(
			modelId: $id,
			modelClass: "App\Models\Event",
		);
	}
}
