<?php
namespace App\Http\Controllers\API;

use App\Models\Decor;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * @group Decors
 *
 * EndPoints pour gérer les décors
 */
class DecorController extends Controller
{

	protected string $modelClass = "\App\Models\Decor";

	protected array $indexSearchFieldList = ["name"];

	/**
	 * Affiche les decors
	 *
	 * @queryParam  name										string			Nom.																		 No-example
	 * @queryParam  start_use									string			Date début d'utilisation.													 No-example
	 * @queryParam  end_use										string			Date fin d'utilisation.														 No-example
	 * @queryParam  event_id									string			Evenement.																	 No-example
	 * 
	 * @queryParam  with_event									string			Afficher l'événement.														Example: false
	 * 
	 * @queryParam  paginate									string			Utiliser la pagination.														Example: false
	 *
	 * @response 200
	 */
	public function index(Request $request)
	{
		$manager = new ImageManager(new Driver());
		return parent::index($request);
	}


	/**
	 * Affiche un décor
	 *
	 * @urlParam	id											integer			L'ID du decor.																Example: 1.
	 *
	 * @queryParam  with_event									string			Afficher l'événement.														Example: false
	 * 
	 * @response 200
	 */
	public function show(Request $request, int $id)
	{
		return parent::show($request, $id);
	}

	public function generate_image($request, $id)
	{
		// Chemins des deux images à superposer
		$imagePath1 = public_path('images/image1.png'); // Image de base
		$imagePath2 = public_path('images/image2.png'); // Image à superposer
		$manager = new ImageManager(new Driver());

		// read image from file system
		$image1 = $manager->read($imagePath1);
		$image2 = $manager->read($imagePath2);
		// Charger la première image
		$image2->resize(200, 200);
		$image1->insert($image2, 'top-left', 50, 50);
		$outputPath = public_path('images/output.png');
		$image1->save($outputPath);
		return response()->download($outputPath);
	}

	/**
	 * Créer un nouveau decor
	 *
	 * @bodyParam  name											string			Nom.																		Example: Base
	 * @bodyParam  file											string			Le décor.																	Example: ...
	 * @bodyParam  start_use									string			Date début d'utilisation.													Example: 2024-10-01
	 * @bodyParam  end_use										string			Date fin d'utilisation.														Example: 2025-01-31
	 * @bodyParam  event_id										string			Evenement.																	Example: 1
	 *
	 * @response 200
	 */
	public function store(Request $request)
	{
		$this->storeValidationArray = [
			"name" => "required|min:2",
			"file" => "required:min:2",
			"start_use" => "required|date",
			"end_use" => "required|date",
			"event_id" => "required|exists:events,id",
		];
		$this->storeManualValidationsFunction = function ($requestData) {
			$event = Event::where("id", $requestData["event_id"])->first();
			if (!$this->checkIsBase64Validated($requestData["file"], ["png"])) {
				return ["errors" => $this->responseError(["file" => ["le fichier n'est pas une image valide"]], 400)];
			}
			if ($file_path = $this->saveImageFromBase64($requestData["file"], "pictures/decors/$event->id/" . Str::slug($requestData["name"]) . ".png")) {
				return ["data" => ["file_path" => $file_path]];
			} else {
				return ["errors" => $this->responseError(["file" => ["Une erreur est survenu durant l'insertion"]])];
			}
		};
		$this->storeBeforeCreateFunction = function ($requestData, $data) {
			$requestData["file_path"] = $data["file_path"];
			$requestData["validation"] = 'pending';
			return $requestData;
		};
		$this->storeRelationArray = ["with_event" => "true"];
		return parent::store($request);
	}

	/**
	 * Mettre à jour un decor
	 *
	 * @urlParam	id											integer	required	L'ID du decor.															Example: 1
	 *
	 * @bodyParam  name											string			Nom.																		Example: Base
	 * @bodyParam  file											string			Le décor.																	Example: ...
	 * @bodyParam  start_use									string			Date début d'utilisation.													Example: 2024-10-01
	 * @bodyParam  end_use										string			Date fin d'utilisation.														Example: 2025-01-31
	 * @bodyParam  event_id										string			Evenement.																	Example: 1
	 *
	 *
	 * @response 200
	 *
	 */
	public function update(Request $request, int $id)
	{
		$this->updateGetValidationArrayFunction = function ($id) {
			return [
				"name" => "required|min:2",
				"file" => "nullable|min:2",
				"start_use" => "required|date",
				"end_use" => "required|date",
				"event_id" => "required|exists:events,id",
			];
		};

		$this->updateManualValidationsFunction = function ($requestData) {
			if (isset($requestData["file"])) {
				$event = Event::where("id", $requestData["event_id"])->first();
				if (!$this->checkIsBase64Validated($requestData["file"], ["png"])) {
					return ["errors" => $this->responseError(["file" => ["le fichier n'est pas une image valide"]], 400)];
				}
				if ($file_path = $this->saveImageFromBase64($requestData["file"], "pictures/decors/$event->id/" . Str::slug($requestData["name"]) . ".png")) {
					return ["data" => ["file_path" => $file_path]];
				} else {
					return ["errors" => $this->responseError(["file" => ["Une erreur est survenu durant l'insertion"]])];
				}
			}
		};

		$this->updateBeforeUpdateFunction = function ($model, $requestData, $data) {
			if (isset($data["file_path"])) {
				$requestData["file_path"] = $data["file_path"];
			}
			return $requestData;
		};

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
		return parent::update($request, $id);
	}

	/**
	 * Supprime un decor
	 *
	 * @urlParam	id											integer	required	L'ID du decor.														Example: 1
	 *
	 * @response 200
	 */
	public function destroy(Request $request, int $id)
	{
		return parent::destroy($request, $id);
	}
}
