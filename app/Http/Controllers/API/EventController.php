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

	protected string $modelClass = "\App\Models\Event";
	protected string|null $indexAbilityName = Null;
	protected string|null $showAbilityName = Null;
	protected array $indexSearchFieldList = ["name", "start_date", "end_date"];


	/**
	 * Affiche les événement
	 *
	 * @queryParam  name										string				Nom.																		 No-example
	 * @queryParam  start_date									string				Date de début.																 No-example
	 * @queryParam  end_date									string				Date de fin.																 No-example
	 * @queryParam  user_id										integer				Créateur.																	 No-example
	 * @queryParam  place										string				Lieu.																		 No-example
	 * @queryParam  type										string				Type.																		 No-example
	 * @queryParam  nb_expected									integer				Nombre de personne attendu.													 No-example
	 * @queryParam  entrance									string				Type d'entrée.																 No-example
	 * @queryParam  entry_price									integer				Prix d'entrée.																 No-example
	 * @queryParam  contact										string				Contact.																	 No-example
	 * @queryParam  description									string				Description detaillée.														 No-example
	 * @queryParam  description_summary							string				Description résumé.															 No-example
	 * 
	 * @queryParam  with_promoter								string				Afficher le promoteur.														Example: false
	 * 
	 * @queryParam  paginate									string				Utiliser la pagination.														Example: false
	 *
	 * @response 200
	 */
	public function index(Request $request)
	{
		return parent::index($request);
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
		return parent::show($request, $id);
	}

	/**
	 * Créer un nouveau decor
	 *
	 * @bodyParam  name											string				Nom.																		Example: Hiver Togo
	 * @bodyParam  start_date									string				Date de début.																Example: 2024-12-01
	 * @bodyParam  end_date										string				La date de début.															Example: 2024-12-01
	 * @bodyParam  place										string				Lieu.																		Example: Lomé
	 * @bodyParam  type											string				Type.																		Example: Dance
	 * @bodyParam  nb_expected									integer				Nombre de personne attendu.													Example: 45
	 * @bodyParam  entrance										string				Type d'entrée.																Example: free
	 * @bodyParam  entry_price									integer				Prix d'entrée.																Example: null
	 * @bodyParam  contact										string				Contact.																	Example: +228 90 90 90 90
	 * @bodyParam  description									string				Description detaillée.														Example: description détaillé
	 * @bodyParam  description_summary							string				Description résumé.															Example: description résumé
	 * @bodyParam  poster										string				Affiche.																	Example: ...
	 * @response 200
	 */
	public function store(Request $request)
	{
		$this->storeValidationArray = [
			"name" => "required|min:2",
			"start_date" => "required|date",
			"end_date" => "nullable|date",
			"place" => "required|min:2",
			"type" => "required|min:2",
			"nb_expected" => "required|numeric",
			"entrance" => "required|in:free,paid",
			"entry_price" => "nullable|numeric",
			"contact" => "required|min:2",
			"description" => "nullable",
			"description_summary" => "required|min:2",
			"poster" => "required"
		];
		$this->storeManualValidationsFunction = function ($requestData) {
			if (!$this->checkIsBase64Validated($requestData["poster"], ["png", "jpeg", "jpg", "webp"])) {
				return ["errors" => ["poster" => ["le fichier n'est pas une image valide"]]];
			}
			if ($poster_path = $this->saveImageFromBase64($requestData["poster"], "pictures/events/" . Str::random(10) . ".png")) {
				return ["data" => ["poster_path" => $poster_path]];
			} else {
				return ["errors" => ["poster" => ["Une erreur est survenu durant l'insertion"]]];
			}
		};
		$this->storeBeforeCreateFunction = function ($requestData, $data) use ($request) {
			$requestData["poster_path"] = $data["poster_path"];
			$requestData["user_id"] = $request->user()->id;
			$requestData["validation"] = 'pending';
			return $requestData;
		};
		$this->storeRelationArray = ["with_promoter" => "true"];
		return parent::store($request);
	}


	/**
	 * Mettre à jour un événement
	 *
	 * @urlParam	id											int	required		L'événement.																Example: 1
	 *
	 * @bodyParam  name											string				Nom.																		Example: Hiver Togo
	 * @bodyParam  start_date									string				Date de début.																Example: 2024-12-01
	 * @bodyParam  end_date										string				La date de début.															Example: 2024-12-01
	 * @bodyParam  place										string				Lieu.																		Example: Lomé
	 * @bodyParam  type											string				Type.																		Example: Dance
	 * @bodyParam  nb_expected									integer				Nombre de personne attendu.													Example: 45
	 * @bodyParam  entrance										string				Type d'entrée.																Example: free
	 * @bodyParam  entry_price									integer				Prix d'entrée.																Example: null
	 * @bodyParam  contact										string				Contact.																	Example: +228 90 90 90 90
	 * @bodyParam  description									string				Description detaillée.														Example: description détaillé
	 * @bodyParam  description_summary							string				Description résumé.															Example: description résumé
	 * @bodyParam  poster										string				Affiche.																	Example: ...
	 *
	 * @response 200
	 *
	 */
	public function update(Request $request, $id)
	{
		$this->updateGetValidationArrayFunction = function ($id) {
			return [
				"name" => "required|min:2",
				"start_date" => "required|date",
				"end_date" => "nullable|date",
				"place" => "required|min:2",
				"type" => "required|min:2",
				"nb_expected" => "required|numeric",
				"entrance" => "required|in:free,paid",
				"entry_price" => "nullable|numeric",
				"contact" => "required|min:2",
				"description" => "nullable",
				"description_summary" => "required|min:2",
				"poster" => "nullable"
			];
		};
		$this->updateManualValidationsFunction = function ($requestData, $model) {
			if (isset($requestData["poster"])) {
				if (!$this->checkIsBase64Validated($requestData["poster"], ["png", "jpeg", "jpg"])) {
					return ["errors" => ["poster" => ["le fichier n'est pas une image valide"]]];
				}
				if ($poster_path = $this->saveImageFromBase64($requestData["poster"], $model->poster_path)) {
					return ["data" => ["poster_path" => $poster_path]];
				} else {
					return ["errors" => ["poster" => ["Une erreur est survenu durant l'insertion"]]];
				}
			}
		};
		$this->updateBeforeUpdateFunction = function ($model, $requestData, $data) use ($request) {
			if (isset($requestData["poster"])) {
				$requestData["poster_path"] = $data["poster_path"];
			}
			return $requestData;
		};
		$this->updateRelationArray = ["with_promoter" => "true"];
		return parent::update($request, $id);
	}

	/**
	 * Mettre à jour la validation d'un événement
	 *
	 * @urlParam	id											int	required		L'événement.																Example: 1
	 *
	 * @bodyParam  validation									string				Nouveau statut.																Example: validated
	 *
	 * @response 200
	 *
	 */
	public function change_validation(Request $request, $id)
	{
		$this->updateGetValidationArrayFunction = function ($id) {
			return [
				"validation" => "required|in:rejected,validated",
			];
		};
		$this->updateBeforeUpdateFunction = function ($model, $requestData, $data) use ($request) {
			return ["validation" => $requestData["validation"]];
		};
		$this->updateRelationArray = ["with_promoter" => "true"];
		return parent::update($request, $id);
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
		return parent::destroy($request, $id);
	}
}
