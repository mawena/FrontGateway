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

	protected array $indexSearchFieldList = ["name", "start_date", "end_date"];


	/**
	 * Affiche les événement
	 *
	 * @queryParam  name										string				Nom.																		 No-example
	 * @queryParam  start_date									string				Date de début.																 No-example
	 * @queryParam  end_date									string				Date de fin.																 No-example
	 * @queryParam  user_id										integer				Promoteur.																	 No-example
	 * @queryParam  place										string				Lieu.																		 No-example
	 * @queryParam  type										string				Type.																		 No-example
	 * @queryParam  nb_expected									integer				Nombre de personne attendu.													 No-example
	 * @queryParam  entrance									string				Type d'entrée.																 No-example
	 * @queryParam  entry_price									integer				Prix d'entrée.																 No-example
	 * @queryParam  contact										string				Contact.																	 No-example
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
	 * @bodyParam  user_id										integer				Promoteur.																	Example: 1
	 * @bodyParam  place										string				Lieu.																		Example: Lomé
	 * @bodyParam  type											string				Type.																		Example: Dance
	 * @bodyParam  nb_expected									integer				Nombre de personne attendu.													Example: 45
	 * @bodyParam  entrance										string				Type d'entrée.																Example: free
	 * @bodyParam  entry_price									integer				Prix d'entrée.																Example: null
	 * @bodyParam  contact										string				Contact.																	Example: +228 90 90 90 90
	 *
	 * @response 200
	 */
	public function store(Request $request)
	{
		$this->storeValidationArray = [
			"name" => "required|min:2",
			"description" => "nullable",
			"start_date" => "required|date",
			"end_date" => "nullable|date",
			"user_id" => "required|exists:users,id",
			"place" => "required|min:2",
			"type" => "required|min:2",
			"nb_expected" => "required|number",
			"entrance" => "required|in:free,paid",
			"entry_price" => "nullable|number",
			"contact" => "required|min:2",
		];
		
		$this->storeBeforeCreateFunction = function ($requestData, $data) use ($request) {
			$requestData["user_id"] = $request->user()->id;
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
	 * @bodyParam  user_id										integer				Promoteur.																	Example: 1
	 * @bodyParam  place										string				Lieu.																		Example: Lomé
	 * @bodyParam  type											string				Type.																		Example: Dance
	 * @bodyParam  nb_expected									integer				Nombre de personne attendu.													Example: 45
	 * @bodyParam  entrance										string				Type d'entrée.																Example: free
	 * @bodyParam  entry_price									integer				Prix d'entrée.																Example: null
	 * @bodyParam  contact										string				Contact.																	Example: +228 90 90 90 90
	 *
	 * @response 200
	 *
	 */
	public function update(Request $request, $id)
	{
		$this->updateGetValidationArrayFunction = function ($id) {
			return [
				"name" => "required|min:2",
				"description" => "nullable",
				"start_date" => "required|date",
				"end_date" => "nullable|date",
				"user_id" => "required|exists:users,id",
				"place" => "required|min:2",
				"type" => "required|min:2",
				"nb_expected" => "required|number",
				"entrance" => "required|in:free,paid",
				"entry_price" => "nullable|number",
				"contact" => "required|min:2",
			];
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
