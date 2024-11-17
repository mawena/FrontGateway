<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

/**
 * @group Utilisateurs
 *
 * EndPoints pour gérer les utilisateurs
 */
class UserController extends Controller
{
	/**
	 * Affiche les utilisateurs
	 *
	 * @queryParam  name										string			Filtrer par nom de l'utilisateur.													 No-example
	 * @queryParam  email										string			Filtrer par email de l'utilisateur.												 	 No-example
	 * @queryParam  profile										string			Filtrer par profile de l'utilisateur.												 No-example
	 * 
	 * @queryParam  with_events									string			Afficher les evenements.															Example: false
	 * 
	 * 
	 * @queryParam  paginate									string			Utiliser la pagination.																Example: false
	 *
	 * @response 200
	 */
	public function index(Request $request)
	{
		if (($authorisation = Gate::inspect('viewAny', User::class))->allowed()) {
			$list = User::query();
			$requestData = $request->all();
			($search = $request->search) ? $list = $this->querySearch($list, ["name", "email", "profile"], $search) : null;
			$list = $this->queryFilter($list, $requestData, "User");
			// $list = $this->queryJSONFilter($list, $requestData, "User");
			$connectedUser = $request->user();
			$list = $this->queryRelationAdd($list, $requestData, "User");
			$list = $connectedUser->profile == "cc" ? $list->where('id', $connectedUser->id) : $list;
			return $this->responseIndexOk($list, $requestData, "User");
		} else {
			return $this->responseError(["auth" => [$authorisation->message()]], 403);
		}
	}


	/**
	 * Affiche un utilsateur
	 *
	 * @urlParam	id											integer			L'ID de l'utilisateur.																Example: 1.
	 *
	 * @queryParam  with_events									string			Afficher les departements.															Example: false
	 * 
	 * @response 200
	 */
	public function show(Request $request, int $id)
	{
		$model = User::find($id);
		$requestData = $request->all();
		if ($model) {
			if (($authorisation = Gate::inspect('view', $model))->allowed()) {
				$model = $this->modelRelationLoad($model, $requestData, "User");
				return $this->responseOk(["user" => $model]);
			} else {
				return $this->responseError(["auth" => [$authorisation->message()]], 403);
			}
		} else {
			return $this->responseError(["id" => "l'utilisateur n'existe pas"], 404);
		}
	}

	/**
	 * Créer un nouvelle utilisateur
	 *
	 * @bodyParam	name										string			  	Le nom de l'utilisateur.													Example: charles.gamligo
	 * @bodyParam	email										string			  	La valeur de l'utilisateur.													Example: charles.gamligo@cofinacorp.com
	 * @bodyParam	password									string			  	L'heure de l'ancement de l'utilisateur.										Example: P@sse123
	 * @bodyParam	profile										string		  		Le profile de l'utilisateur.												Example: admin
	 * @bodyParam	picture										string				L'image de l'utilisateur.													Example: 0
	 *
	 * @response 200
	 */
	public function store(Request $request)
	{
		return $this->modelStore(
			modelClass: "App\Models\User",
			requestData: $request->all(),
			validations: [
				'name' => 'required|unique:users',
				'email' => 'required|unique:users',
				"password" => "required|min:8",
				"activated" => "required|boolean",
				"profile" => "required|in:super-admin,admin,organiser",
				"picture" => "nullable"
			],
			manualValidations: function ($requestData) {
				if (isset($requestData["picture"])) {
					if (!$this->checkIsBase64Validated($requestData["file"], ["png", "jpeg", "jpg"])) {
						return ["errors" => $this->responseError(["file" => ["le fichier n'est pas une image valide"]], 400)];
					}
					if ($picture_path = $this->saveImageFromBase64($requestData["file"], "users/pictures/" . Str::slug($requestData["name"]) . ".png")) {
						return ["data" => ["picture_path" => $picture_path]];
					} else {
						return ["errors" => $this->responseError(["file" => ["Une erreur est survenu durant l'insertion"]])];
					}
				}
			},
			beforeCreate: function ($requestData, $data) {
				$requestData["password"] = Hash::make($requestData["password"]);
				$requestData["picture_path"] = isset($data["picture_path"]) ? $data["picture_path"] : "users/defauts/picture.png";
				return $requestData;
			},
			relations: ["with_events" => "true"]
		);
	}

	/**
	 * Mettre à jour un utilisateur
	 *
	 * @urlParam	id											int	required		L'ID de l'utilisateur.														Example: 1
	 *
	 * @bodyParam	name										string			  	Le nom de l'utilisateur.													Example: charles.gamligo
	 * @bodyParam	email										string			  	La valeur de l'utilisateur.													Example: charles.gamligo@cofinacorp.com
	 * @bodyParam	password									string			  	L'heure de l'ancement de l'utilisateur.										Example: P@sse123
	 * @bodyParam	profile										string		  		Le profile de l'utilisateur.												Example: admin
	 * @bodyParam	picture										string				L'image de l'utilisateur.													Example: 0
	 *
	 * @response 200
	 *
	 */
	public function update(Request $request, int $id)
	{
		return $this->modelUpdate(
			modelId: $id,
			modelClass: "App\Models\User",
			requestData: $request->all(),
			validations: [
				"name" => "required|unique:users,name," . $id,
				"email" => "required|unique:users,email," . $id,
				"password" => "nullable|min:8",
				"activated" => "required|boolean",
				"profile" => "required|in:admin,supervisor,organiser",
				"picture" => "nullable"
			],
			manualValidations: function ($requestData) {
				if (isset($requestData["picture"])) {
					if (!$this->checkIsBase64Validated($requestData["file"], ["png", "jpeg", "jpg"])) {
						return ["errors" => $this->responseError(["file" => ["le fichier n'est pas une image valide"]], 400)];
					}
					if ($picture_path = $this->saveImageFromBase64($requestData["file"], "users/pictures/" . Str::slug($requestData["name"]) . ".png")) {
						return ["data" => ["picture_path" => $picture_path]];
					} else {
						return ["errors" => $this->responseError(["file" => ["Une erreur est survenu durant l'insertion"]])];
					}
				}
			},
			beforeUpdate: function ($model, $requestData, $data) {
				if (isset($requestData["password"])) {
					$requestData["password"] = Hash::make($requestData["password"]);
				}else{
					unset($requestData["password"]);
				}

				if(isset($data["picture_path"])){
					$requestData["picture_path"] = $data["picture_path"];
				}else{
					unset($requestData["picture_path"]);
				}

				return $requestData;
			},
			relations: ["with_events" => "true"]
		);
	}

	/**
	 * Mettre à jour le mot de passe de l'utilisateur connecté utilisateur
	 *
	 * @bodyParam	old_password							string	required	L'ancien mot de passe de l'utilisateur.										No-example
	 * @bodyParam	new_password							string	required	Le nouveau mot de passe de l'utilisateur.									No-example
	 * @bodyParam	new_password_confirmation				string	required	La confirmation du nouveau mot de passe de l'utilisateur.					No-example
	 *
	 * @response 200
	 *
	 */
	public function update_password(Request $request)
	{
		$model = $request->user();
		return $this->modelUpdate(
			modelId: $model->id,
			modelClass: "App\Models\User",
			requestData: $request->all(),
			validations: [
				"old_password" => 'required|min:2',
				"new_password" => 'required|min:8',
				"new_password_confirmation" => 'required|min:8|same:new_password',
			],
			validationsText: [
				"same" => "Ce mot de passe est différent"
			],
			manualValidations: function ($requestData, $model) {
				if (Hash::check($requestData["old_password"], $model["password"])) {
					return [
						"data" => ["user" => $model]
					];
				} else {
					return [
						"errors" => ["old_password" => ["Ancien mot de passe incorect"]],
						"status" => 400
					];
				}
			},
			beforeUpdate: function ($model, $requestData) {
				return [
					"password" => Hash::make($requestData["new_password"]),
					"password_change_required" => false
				];
			},
			afterUpdate: function ($requestData) use ($model) {
				$model->tokens()->each(function ($token, $key) {
					$token->delete();
				});
				// return $model;
			},
			authName: "update_password"
		);
	}

	/**
	 * Supprime un utilisateur
	 *
	 * @urlParam	id											int required		L'ID de l'utilisateur.														Example: 1
	 *
	 * @response 200
	 */
	public function destroy(int $id)
	{
		return $this->modelDelete(
			modelId: $id,
			modelClass: "App\Models\Script",
		);
	}
}
