<?php

namespace App\Http\Controllers\API;

use App\Models\Configuration;
use Illuminate\Http\Request;


/**
 * @group Paiements
 *
 * EndPoints pour gérer les paiements
 */
class PaymentController extends Controller
{
	protected string $modelClass = "\App\Models\Payment";
	protected array $indexSearchFieldList = ["amount", "currency", "description"];


	/**
	 * Affiche les paiements
	 *
	 * @queryParam  user_id										integer				Promoteur.																	 No-example
	 * @queryParam  nb_uses										integer				Nombre d'utilisation de décor.												 No-example
	 * @queryParam  amount										integer				Montant.																	 No-example
	 * @queryParam  currency									string				Devise.																		 No-example
	 * @queryParam  description									string				Description.																 No-example
	 * @queryParam  status										string				Statut.																		 No-example
	 * 
	 * @queryParam  with_user									string				Afficher le promoteur.														Example: false
	 * 
	 * @queryParam  paginate									string				Utiliser la pagination.														Example: false
	 *
	 * @response 200
	 */
	public function index(Request $request)
	{
		$this->indexManualFilter = function ($list, $connectedUser) {
			$list = $connectedUser->profile == "promoter" ? $list->where('user_id', $connectedUser->id) : $list;
			return $list;
		};
		return parent::index($request);
	}

	/**
	 * Affiche un paiement
	 *
	 * @urlParam	id											integer				Le paiement.																Example: 1.
	 *
	 * @queryParam  with_user									string				Afficher le promoteur.														Example: false
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
	 * @bodyParam  user_id										integer				Promoteur.																	Example: 1
	 * @bodyParam  nb_uses										integer				Nombre d'utilisation de décor.												Example: 5
	 * @bodyParam  currency										string				Devise.																		Example: XOF
	 * @bodyParam  description									string				Description.																Example: Payement de 100 utilisation de décors
	 * 
	 * @response 200
	 */
	public function store(Request $request)
	{
		$this->storeValidationArray = [
			"user_id" => "required|exists:users,id",
			"nb_uses" => "required|numeric",
			"currency" => "nullable|in:XOF,XAF,CDF,GNF,USD",
			"description" => "required|min:2",
		];
		$this->storeBeforeCreateFunction = function ($requestData, $data) use ($request) {
			$unit_price_conf = Configuration::get(1);
			$requestData["satus"] = $data["initiated"];
			$requestData["amount"] = (float) ($unit_price_conf["value"]) * $requestData["nb_uses"];
			return $requestData;
		};
		return parent::store($request);
	}
}
