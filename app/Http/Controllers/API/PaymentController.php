<?php

namespace App\Http\Controllers\API;

use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


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
	 * Créer un nouveau paiement
	 *
	 * @bodyParam  country_code									string				Pays.																		Example: 228
	 * @bodyParam  phone_number									string				Tel.																		Example: 91611135
	 * @bodyParam  nb_uses										integer				Nombre d'utilisation de décor.												Example: 5
	 * 
	 * @response 200
	 */
	public function store(Request $request)
	{
		$conf = [
			"unit_price" => Configuration::where('id', 1)->first(),
			"api_token" => Configuration::where('id', 2)->first(),
			"api_post_link" => Configuration::where('id', 3)->first(),
			"api_callback_link" => Configuration::where('id', 4)->first(),
			"api_site_sid" => Configuration::where('id', 5)->first(),
			"api_secret_key" => Configuration::where('id', 6)->first(),
			"return_url" => Configuration::where('id', 7)->first(),
		];
		$this->storeValidationArray = [
			"country_code" => "required|in:228",
			"phone_number" => "required|min:2",
			"nb_uses" => "required|integer|min:4",
		];
		$this->storeBeforeCreateFunction = function ($requestData, $data) use ($request, $conf) {
			$connectedUser = $request->user();
			$requestData["user_id"] = $connectedUser->id;
			$requestData["satus"] = "initiated";
			$requestData["currency"] = "XOF";
			$requestData["status"] = "initiated";
			$requestData["description"] = "Achat de " . $requestData["nb_uses"] . " utilisations de décors";
			$requestData["amount"] = (float) ($conf["unit_price"]["value"]) * $requestData["nb_uses"];

			$requestData["transaction_id"]= Str::random("10");

			$response = Http::withHeaders([])->post($conf["api_post_link"]["value"], [
				"apikey" => $conf["api_token"]["value"],
				"site_id" => $conf["api_site_sid"]["value"],
				"transaction_id" => $requestData["transaction_id"],
				"amount" => $requestData["amount"],
				"currency" => $requestData["currency"],
				"description" => $requestData["description"],
				"notify_url" => $conf["return_url"]["value"],
				"channels" => "MOBILE_MONEY",
				"lang" => "fr",
			])->json();

			$requestData["payment_token"] = $response["data"]["payment_token"];
			$requestData["payment_url"] = $response["data"]["payment_url"];

			return $requestData;
		};

		return parent::store($request);
	}

	public function callback(Request $request) {}
}
