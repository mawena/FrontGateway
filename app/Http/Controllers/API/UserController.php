<?php

namespace App\Http\Controllers\API;

use App\Models\Configuration;
use App\Models\Payment;
use App\Models\Promoter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * @group Utilisateurs
 *
 * EndPoints pour gérer les utilisateurs
 */
class UserController extends Controller
{
	protected string $modelClass = "\App\Models\User";

	/**
	 * Affiche les utilisateurs
	 *
	 * @queryParam  name										string			Filtrer par nom de l'utilisateur.													 No-example
	 * @queryParam  email										string			Filtrer par email de l'utilisateur.												 	 No-example
	 * @queryParam  profile										string			Filtrer par profile de l'utilisateur.												 No-example
	 * 
	 * @queryParam  with_events									string			Afficher les evenements.															Example: false
	 * @queryParam  with_decors									string			Afficher les décors.																Example: false
	 * @queryParam  with_payments								string			Afficher les paiements.																Example: false
	 * 
	 * 
	 * @queryParam  paginate									string			Utiliser la pagination.																Example: false
	 *
	 * @response 200
	 */
	public function index(Request $request)
	{
		$this->indexManualFilter = function ($list, $connectedUser) {
			$list = $connectedUser->profile == "supervisor" ? $list->where('profile', '<>', 'admin') : $list;
			$list = $connectedUser->profile == "promoter" ? $list->where('profile', 'promoter') : $list;
			return $list;
		};
		return parent::index($request);
	}


	/**
	 * Affiche un utilsateur
	 *
	 * @urlParam	id											integer			L'ID de l'utilisateur.																Example: 1.
	 *
	 * @queryParam  with_events									string			Afficher les evenements.															Example: false
	 * @queryParam  with_decors									string			Afficher les décors.																Example: false
	 * @queryParam  with_payments								string			Afficher les paiements.																Example: false
	 * 
	 * @response 200
	 */
	public function show(Request $request, int $id)
	{
		return parent::show($request, $id);
	}

	/**
	 * Créer un nouvelle utilisateur
	 *
	 * @bodyParam	name										string			  	Le nom de l'utilisateur.													Example: charles.gamligo
	 * @bodyParam	email										string			  	La valeur de l'utilisateur.													Example: charles.gamligo@cofinacorp.com
	 * @bodyParam	password									string			  	L'heure de l'ancement de l'utilisateur.										Example: P@sse123
	 * @bodyParam	activated									integer			  	L'activation.																Example: 0
	 * @bodyParam	profile										string		  		Le profile de l'utilisateur.												Example: admin
	 * @bodyParam	picture										string				L'image de l'utilisateur.													Example: 0
	 *
	 * @response 200
	 */
	public function store(Request $request)
	{
		$this->storeValidationArray = [
			'name' => 'required|unique:users',
			'email' => 'required|unique:users',
			"password" => "required|min:8",
			"activated" => "required|boolean",
			"profile" => "required|in:admin,supervisor,promoter,money_manager,event_planner,visitor",
			"picture" => "nullable"
		];
		$this->storeManualValidationsFunction = function ($requestData) {
			if ($requestData["profile"] == "promoter") {
				$validator = Validator::make($requestData, [
					"promoter.structure" => "required|min:2",
					"promoter.phone_number" => "required|min:2",
					"promoter.birth_date" => "required|date",
					"promoter.sex" => "required|in:M,F",
				],);
				if ($validator->fails()) {
					return ["errors" => $validator->errors()->toArray(), "status" => 400];
				}
			}

			if (isset($requestData["picture"])) {
				if (!$this->checkIsBase64Validated($requestData["picture"], ["png", "jpeg", "jpg"])) {
					return ["errors" => ["picture" => ["le fichier n'est pas une image valide"]]];
				}
				if ($picture_path = $this->saveImageFromBase64($requestData["picture"], "pictures/users/" . Str::slug($requestData["name"]) . ".png")) {
					return ["data" => ["picture_path" => $picture_path]];
				} else {
					return ["errors" => ["picture" => ["Une erreur est survenu durant l'insertion"]]];
				}
			}
		};
		$this->storeBeforeCreateFunction = function ($requestData, $data) {
			$requestData["password"] = Hash::make($requestData["password"]);
			$requestData["picture_path"] = isset($data["picture_path"]) ? $data["picture_path"] : "defaults/user.png";
			return $requestData;
		};
		$this->storeBeforeCommitFunction = function ($model, $requestData) {
			if ($requestData["profile"] == "promoter") {
				$requestData["promoter"]["user_id"] = $model->id;
				Promoter::create($requestData["promoter"]);
				
				$conf = [
					"unit_price" => Configuration::where('id', 1)->first(),
					"api_token" => Configuration::where('id', 2)->first(),
					"api_post_link" => Configuration::where('id', 3)->first(),
					"api_callback_link" => Configuration::where('id', 4)->first(),
					"api_site_sid" => Configuration::where('id', 5)->first(),
					"api_secret_key" => Configuration::where('id', 6)->first(),
					"return_url" => Configuration::where('id', 7)->first(),
					"free_nb_uses" => Configuration::where('id', 8)->first(),
				];
				Payment::create([
					"user_id" => $model->id,
					"nb_uses" => $conf["free_nb_uses"]["value"],
					"amount" => 0,
					"currency" => "XAF",
					"description" => "Création du compte",
					"status" => "validated",
					"phone_number" => "",
					"payment_url" => "",
					"payment_token" => "",
					"transaction_id" => ""
				]);
			}
			return $model;
		};
		$this->storeRelationArray = ["with_events" => "true", "with_promoter" => "true"];
		return parent::store($request);
	}

	/**
	 * Mettre à jour un utilisateur
	 *
	 * @urlParam	id											int	required		L'ID de l'utilisateur.														Example: 1
	 *
	 * @bodyParam	name										string			  	Le nom de l'utilisateur.													Example: charles.gamligo
	 * @bodyParam	email										string			  	La valeur de l'utilisateur.													Example: charles.gamligo@cofinacorp.com
	 * @bodyParam	password									string			  	L'heure de l'ancement de l'utilisateur.										Example: P@sse123
	 * @bodyParam	activated									integer			  	L'activation.																Example: 0
	 * @bodyParam	profile										string		  		Le profile de l'utilisateur.												Example: admin
	 * @bodyParam	picture										string				L'image de l'utilisateur.													Example: 0
	 *
	 * @response 200
	 *
	 */
	public function update(Request $request, int $id)
	{
		$this->updateGetValidationArrayFunction = function ($id) {
			return [
				"name" => "required|unique:users,name," . $id,
				"email" => "required|unique:users,email," . $id,
				"password" => "nullable|min:8",
				"activated" => "required|boolean",
				"profile" => "required|in:admin,supervisor,promoter,money_manager,event_planner,visitor",
				"picture" => "nullable"
			];
		};
		$this->updateManualValidationsFunction = function ($requestData, $model) {
			if ($requestData["profile"] == "promoter") {
				$validator = Validator::make($requestData, [
					"promoter.structure" => "required|min:2",
					"promoter.phone_number" => "required|min:2",
					"promoter.birth_date" => "required|date",
					"promoter.sex" => "required|in:M,F",
				],);
				if ($validator->fails()) {
					return ["errors" => $validator->errors()->toArray(), "status" => 400];
				}
			}

			if (isset($requestData["picture"])) {
				if (!$this->checkIsBase64Validated($requestData["picture"], ["png", "jpeg", "jpg"])) {
					return ["errors" => ["picture" => ["le fichier n'est pas une image valide"]]];
				}
				if ($picture_path = $this->saveImageFromBase64($requestData["picture"], "pictures/users/" . Str::slug($requestData["name"]) . ".png")) {
					return ["data" => ["picture_path" => $picture_path]];
				} else {
					return ["errors" => ["picture" => ["Une erreur est survenu durant l'insertion"]]];
				}
			}
		};
		$this->updateBeforeUpdateFunction = function ($model, $requestData, $data) use ($request) {
			if (isset($requestData["password"])) {
				$requestData["password"] = Hash::make($requestData["password"]);
			} else {
				unset($requestData["password"]);
			}

			if (isset($data["picture_path"])) {
				$requestData["picture_path"] = $data["picture_path"];
			} else {
				unset($requestData["picture_path"]);
			}

			if ($requestData["profile"] == "promoter") {
				if ($model->promoter) {
					$promoter = Promoter::find($model->promoter->id);
					$promoter->update($requestData["promoter"]);
				} else {
					Promoter::create($requestData["promoter"]);
				}
			}
			return $requestData;
		};
		$this->updateRelationArray = ["with_events" => "true"];
		return parent::update($request, $id);
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
				return $model;
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
	public function destroy(Request $request, int $id)
	{
		return parent::destroy($request, $id);
	}
}
