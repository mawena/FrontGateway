<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\CustomResponseTrait;
use App\Http\Traits\ControllerHelperTrait;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
	use AuthorizesRequests, ValidatesRequests, CustomResponseTrait, ControllerHelperTrait;

	protected string $modelName;
	protected string $modelClass = "";

	//Index, show and destroy
	protected string|null $indexAbilityName = "viewAny";
	protected string|null $showAbilityName = "viewAny";
	protected $indexManualFilter = null;
	protected array $indexSearchFieldList = [];


	//Store
	protected string|null $storeAuthName = "create";
	protected array $storeValidationArray = [];
	protected array $storeValidationTextArray = [];
	protected $storeManualValidationsFunction = null;
	protected $storeBeforeCreateFunction = null;
	protected $storeAfterCreateFunction = null;
	protected $storeBeforeCommitFunction = null;
	protected $storeAfterCommitFunction = null;
	protected array $storeRelationArray = [];

	//Update
	protected string|null $updateAuthName = "update";
	protected $updateGetValidationArrayFunction = [];
	protected array $updateValidationTextArray = [];
	protected $updateManualValidationsFunction = null;
	protected $updateBeforeUpdateFunction = null;
	protected $updateAfterUpdateFunction = null;
	protected $updateBeforeCommitFunction = null;
	protected $updateAfterCommitFunction = null;
	protected array $updateRelationArray = [];

	public function __construct()
	{
		$elements = explode('\\', $this->modelClass);
		$this->modelName = end($elements);
	}

	public function index(Request $request)
	{
		if($this->indexAbilityName){
			if (!($authorisation = Gate::inspect($this->indexAbilityName, $this->modelClass))->allowed()) {
				return $this->responseError(["auth" => [$authorisation->message()]], 403);
			}
		}
		dd("dadada");
		$list = call_user_func([$this->modelClass, 'query']);

		$requestData = $request->all();
		($search = $request->search) ? $list = $this->querySearch($list, $this->indexSearchFieldList, $search) : null;
		$list = $this->queryFilter($list, $requestData, $this->modelName);
		$list = $this->queryFilterIn($list, $requestData, $this->modelName);
		$list = $this->queryRelationAdd($list, $requestData, $this->modelName);
		$connectedUser = $request->user();
		if ($this->indexManualFilter) {
			$list = ($this->indexManualFilter)($list, $connectedUser);
		}
		return $this->responseIndexOk($list, $requestData, $this->modelName);
	}

	public function show(Request $request, int $id)
	{
		$model = call_user_func_array([$this->modelClass, 'find'], [$id]);
		$requestData = $request->all();
		if ($model) {
			if($this->showAbilityName){
				if (!($authorisation = Gate::inspect($this->showAbilityName, $model))->allowed()) {
					return $this->responseError(["auth" => [$authorisation->message()]], 403);
				}
			}
			$model = $this->modelRelationLoad($model, $requestData, $this->modelName);
			return $this->responseOk([$this->modelName => $model]);
		} else {
			return $this->responseError(["id" => ["l'élément n'existe pas"]], 404);
		}
	}

	public function store(Request $request)
	{
		return $this->modelStore(
			modelClass: $this->modelClass,
			requestData: $request->all(),
			validations: $this->storeValidationArray,
			validationsText: $this->storeValidationTextArray,
			manualValidations: $this->storeManualValidationsFunction,
			beforeCreate: $this->storeBeforeCreateFunction,
			afterCreate: $this->storeAfterCreateFunction,
			beforeCommit: $this->storeBeforeCommitFunction,
			afterCommit: $this->storeAfterCommitFunction,
			authName: $this->storeAuthName,
			relations: $this->storeRelationArray,
		);
	}

	public function update(Request $request, int $id)
	{
		return $this->modelUpdate(
			modelId: $id,
			modelClass: $this->modelClass,
			requestData: $request->all(),
			validations: ($this->updateGetValidationArrayFunction)($id),
			validationsText: $this->updateValidationTextArray,
			manualValidations: $this->updateManualValidationsFunction,
			beforeUpdate: $this->updateBeforeUpdateFunction,
			afterUpdate: $this->updateAfterUpdateFunction,
			beforeCommit: $this->updateBeforeCommitFunction,
			afterCommit: $this->updateAfterCommitFunction,
			authName: $this->updateAuthName,
			relations: $this->updateRelationArray,
		);
	}

	public function destroy(Request $request, int $id)
	{
		return $this->modelDelete(
			modelId: $id,
			modelClass: $this->modelClass,
		);
	}


	/**
	 * Enregistrer un model
	 * @param 	mixed 		$modelClass			La classe du model
	 * @param 	array 		$requestData		Les données de la requête
	 * @param 	array 		$validations		Les données des validations à effectuer
	 * @param 	array 		$validationsText	Les textes des validations à effectuer
	 * @param 	array 		$manualValidations	Une fonction de validations manuelles
	 * @param 	callable 	$beforeCreate		Une fonction à appeler avant l'insertion, params : requestData: Les données de la requête, manualValidationsReturnData: les données retournées par la validation manuelle
	 * @param 	callable 	$afterCreate		Une fonction à appeler après l'insertion, params : model: le model fraichement crée, requestData: Les données de la requête, manualValidationsReturnData: les données retournées par la validation manuelle
	 * @param 	callable 	$beforeCommit		Une fonction à appeler avant le commit, params : model: le model fraichement crée, requestData: Les données de la requête, manualValidationsReturnData: les données retournées par la validation manuelle
	 * @param 	callable 	$afterCommit		Une fonction à appeler après le commit, params : model: le model fraichement crée, requestData: Les données de la requête, manualValidationsReturnData: les données retournées par la validation manuelle
	 * @param 	string	    $authName   		Le nom de la fonction de police à utiliser
	 * @param 	array	    $relations   		Les relations à afficher lors de retour
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function modelStore($modelClass, array $requestData, array $validations = [], array $validationsText = [], callable $manualValidations = null, callable $beforeCreate = null, callable $afterCreate = null, callable $beforeCommit = null, callable $afterCommit = null, string|null $authName = "create", $relations = [])
	{
		if ($authName && !($authorisation = Gate::inspect($authName, $modelClass))->allowed()) {
			return $this->responseError(["auth" => [$authorisation->message()]], 403);
		}
		$validator = Validator::make($requestData, $validations, $validationsText);
		if ($validator->fails()) {
			return $this->responseError($validator->errors()->toArray(), 400);
		}
		DB::beginTransaction();
		$manualValidationsReturn = ($manualValidations) ? $manualValidations($requestData) : null;
		if (isset($manualValidationsReturn["errors"])) {
			if ($manualValidationsReturn["errors"]) {
				return $this->responseError($manualValidationsReturn["errors"], $manualValidationsReturn["status"] ?? 400);
			}
		}
		$manualValidationsReturn["data"] = isset($manualValidationsReturn["data"]) ? $manualValidationsReturn["data"] : [];
		$requestData = ($beforeCreate) ? $beforeCreate($requestData, $manualValidationsReturn["data"]) : $requestData;
		$model = call_user_func_array([$modelClass, 'create'], [$requestData]);
		$model = ($afterCreate) ? $afterCreate($model, $requestData, $manualValidationsReturn["data"]) : $model;
		$modelClassExployed = explode("\\", $modelClass);
		$model = ($beforeCommit) ? $beforeCommit($model, $requestData, $manualValidationsReturn["data"]) : $model;
		DB::commit();
		$model = ($afterCommit) ? $afterCommit($model, $requestData, $manualValidationsReturn["data"]) : $model;
		$model = $relations ? $this->modelRelationLoad($model, $relations, end($modelClassExployed)) : $model;
		return $this->responseOk([
			lcfirst(end($modelClassExployed)) => $model
		], status: 201);
	}

	/**
	 * Mettre à jour un model
	 * @param 	mixed 		$modelId			L'ID du model
	 * @param 	mixed 		$modelClass			La classe du model
	 * @param 	array 		$requestData		Les données de la requête
	 * @param 	array 		$validations		Les données des validations à effectuer
	 * @param 	array 		$validationsText	Les textes des validations à effectuer
	 * @param 	array 		$manualValidations	Une fonction de validations manuelles
	 * @param 	callable 	$beforeUpdate		Une fonction à appeler avant la mise à jour, params : model: le model actuel, requestData: Les données de la requête, manualValidationsReturnData: les données retournées par la validation manuelle
	 * @param 	callable 	$afterUpdate		Une fonction à appeler après la mise à jour, params : model: le model fraichement mis à jour, requestData: Les données de la requête, manualValidationsReturnData: les données retournées par la validation manuelle
	 * @param 	callable 	$beforeCommit		Une fonction à appeler avant le commit, params : model: le model fraichement mis à jour, requestData: Les données de la requête, manualValidationsReturnData: les données retournées par la validation manuelle
	 * @param 	callable 	$afterCommit		Une fonction à appeler après le commit, params : model: le model fraichement mis à jour, requestData: Les données de la requête, manualValidationsReturnData: les données retournées par la validation manuelle
	 * @param 	string	    $authName   		Le nom de la fonction de police à utiliser
	 * @param 	array	    $relations   		Les relations à afficher lors de retour
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function modelUpdate(mixed $modelId, $modelClass, array $requestData, array $validations = [], array $validationsText = [], callable $manualValidations = null, callable $beforeUpdate = null, callable $afterUpdate = null, callable $beforeCommit = null, callable $afterCommit = null, string|null $authName = "update", $elementName = "L'élément", $relations = [])
	{
		if ($modelId) {
			$validator = Validator::make($requestData, $validations, $validationsText);
			if ($validator->fails()) {
				return $this->responseError($validator->errors()->toArray(), 400);
			}
			$modelClassExployed = explode("\\", $modelClass);
			$model = call_user_func_array([$modelClass, 'find'], [$modelId]);
			$modelClassName = lcfirst(end($modelClassExployed));
			if ($model) {
				if ($authName && !($authorisation = Gate::inspect($authName, $model))->allowed()) {
					return $this->responseError(["auth" => [$authorisation->message()]], 403);
				}
				DB::beginTransaction();
				$manualValidationsReturn = ($manualValidations) ? $manualValidations($requestData, $model) : null;
				if (isset($manualValidationsReturn["errors"])) {
					if ($manualValidationsReturn["errors"]) {
						return $this->responseError($manualValidationsReturn["errors"], $manualValidationsReturn["status"] ?? 400);
					}
				}
				$manualValidationsReturn["data"] = isset($manualValidationsReturn["data"], $model) ? $manualValidationsReturn["data"] : [];
				$requestData = ($beforeUpdate) ? $beforeUpdate($model, $requestData, $manualValidationsReturn["data"]) : $requestData;
				$model->update($requestData);
				$model = (($afterUpdate) ? $afterUpdate($model, $requestData, $manualValidationsReturn["data"]) : $model) ?? $model;
				$model = ($beforeCommit) ? $beforeCommit($model, $requestData, $manualValidationsReturn["data"]) : $model;
				$model = $relations ? $this->modelRelationLoad($model, $relations, end($modelClassExployed)) : $model;
				DB::commit();
				$model = ($afterCommit) ? $afterCommit($model, $requestData, $manualValidationsReturn["data"]) : $model;
				return $this->responseOk([
					$modelClassName => $model
				]);
			} else {
				return $this->responseError(["id" => ["$elementName n'existe pas"]], 404);
			}
		} else {
			return $this->responseError(["id" => ["$elementName est manquant"]], 401);
		}
	}

	/**
	 * Supprimer un model
	 * @param 	mixed 		$modelId			L'ID du model
	 * @param 	mixed 		$modelClass			La classe du model
	 * @param 	array 		$manualValidations	Une fonction de validations manuelles
	 * @param 	callable 	$beforeDelete		Une fonction à appeler avant la suppression
	 * @param 	callable 	$afterDelete		Une fonction à appeler après la suppression
	 * @param 	string	    $authName   		Le nom de la fonction de police à utiliser
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function modelDelete(int $modelId, $modelClass, callable $manualValidations = null, callable $beforeDelete = null, callable $afterDelete = null, $authName = "delete", $elementName = "L'élément")
	{
		$modelClassExployed = explode("\\", $modelClass);
		$model = call_user_func_array([$modelClass, 'find'], [$modelId]);
		$modelClassName = lcfirst(end($modelClassExployed));
		if ($model) {
			if ($authName && !($authorisation = Gate::inspect($authName, $model))->allowed()) {
				return $this->responseError(["auth" => [$authorisation->message()]], 403);
			}
			$manualValidationsErrors = ($manualValidations) ? $manualValidations() : null;
			if ($manualValidationsErrors) {
				return $manualValidationsErrors;
			}
			($beforeDelete) ? $beforeDelete() : null;
			if ($model->delete()) {
				$model = ($afterDelete) ? $afterDelete($model) : $model;
				return $this->responseOk(messages: [$modelClassName => "$elementName a été supprimé"]);
			} else {
				return $this->responseError(["server" => ["Erreur du serveur"]], 500);
			}
		} else {
			return $this->responseError(["id" => ["$elementName n'existe pas"]], 404);
		}
	}
}
