<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @group Configuration
 *
 * EndPoints pour gérer les configurations
 */
class ConfigurationController extends Controller
{
	protected string $modelClass = "\App\Models\Configuration";
	protected string|null $indexAbilityName = Null;
	protected string|null $showAbilityName = Null;
	protected array $indexSearchFieldList = ["key", "value"];


	/**
	 * Affiche les configurations
	 *
	 * @queryParam  key											string				Clé.																		 No-example
	 * @queryParam  value										string				Valeur.																		 No-example
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
	 * Affiche un configuration
	 *
	 * @urlParam	id											integer				Configuration.																Example: 1.
	 *
	 * @response 200
	 */
	public function show(Request $request, $id)
	{
		return parent::show($request, $id);
	}

	/**
	 * Créer une nouvelle configuration
	 *
	 * @bodyParam  key											string				Clé.																		Example: decor_unit_price
	 * @bodyParam  value										string				Valeur.																		Example: 25
	 * 
	 * @response 200
	 */
	public function store(Request $request)
	{
		$this->storeValidationArray = [
			"key" => "required|unique:configurations",
			"value" => "required",
		];
		return parent::store($request);
	}


	/**
	 * Mettre à jour une configuration
	 *
	 * @urlParam	id											int	required		Configuration.																Example: 1
	 *
	 * @bodyParam  value										string				Valeur.																		Example: 25
	 *
	 * @response 200
	 *
	 */
	public function update(Request $request, $id)
	{
		$this->updateGetValidationArrayFunction = function ($id) {
			return [
				"value" => "required",
			];
		};
		return parent::update($request, $id);
	}

	/**
	 * Supprime une configuration
	 *
	 * @urlParam	id											int required			Configuration.															Example: 1
	 *
	 * @response 200
	 */
	public function destroy(Request $request, $id)
	{
		return parent::destroy($request, $id);
	}
}
