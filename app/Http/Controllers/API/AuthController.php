<?php

namespace App\Http\Controllers\API;

use App\Http\Traits\CustomResponseTrait;
use App\Models\Promoter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @group Authentification
 *
 * EndPoints pour gérer l'authentification
 */
class AuthController extends Controller
{
	use CustomResponseTrait;

	protected string $modelClass = "\App\Models\User";

	/**
	 * Connecte un utilisateur
	 *
	 * @bodyParam email			string		required	L'email de l'utilsateur.						Example: admin@pecorator.com
	 * @bodyParam password		string		required	Le mot de passe complet de l'utilisateur.		Example: azerty
	 *
	 * @response 200
	 */
	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|exists:users',
			"password" => 'required'
		]);
		if ($validator->fails()) {
			return $this->responseError($validator->errors()->toArray(), 400);
		}

		$user = User::where('email', $request->email)->first();
		if (Hash::check($request->password, $user->password)) {
			return $this->responseOk([
				"userToken" => $user->createToken($request->email)->plainTextToken,
				"user" => $user->toArray(),
			]);
		} else {
			return $this->responseError(["password" => ["Mot de passe incorrect"]], 400);
		}
	}

	public function register(Request $request)
	{
		$this->storeValidationArray = [
			'name' => 'required|unique:users',
			'email' => 'required|unique:users',
			"structure" => "required|min:2",
			"phone_number" => "required|min:2",
			"birth_date" => "required|date",
			"sex" => "required|in:M,H",
			"picture" => "nullable",
			"password" => "required|min:8",
		];
		$this->storeAuthName = null;
		$this->storeManualValidationsFunction = function ($requestData) {
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
			$requestData["profile"] = "promoter";
			$requestData["activated"] = true;
			return $requestData;
		};
		$this->storeBeforeCommitFunction = function ($model, $requestData) {
			Promoter::create([
				"user_id" => $model->id,
				"structure" => $requestData["structure"],
				"phone_number" => $requestData["phone_number"],
				"birth_date" => $requestData["birth_date"],
				"sex" => $requestData["sex"],
			]);
			return $model;
		};
		$this->storeAfterCommitFunction = function ($model, $requestData) {
			// $model["userToken"] = $model->createToken($model->name)->plainTextToken;
			return $model;
		};
		$this->storeRelationArray = ["with_events" => "true", "with_promoter" => "true"];
		return parent::store($request);
	}

	/**
	 * Affiche l'utilisateur connecté
	 *
	 * @response 200
	 */
	public function show(Request $request, int $id)
	{
		return $this->responseOk($request->user()->toArray());
	}

	/**
	 * Déconnecte l'utilisateur connecté
	 *
	 * @response 204
	 */
	public function logout(Request $request)
	{
		if ($request->user()->currentAccessToken()->delete()) {
			return $this->responseOk(["messages" => ["logout done"]]);
		} else {
			return $this->responseError(["errors" => ["error during logout"]]);
		}
	}
}
