<?php

namespace App\Http\Controllers\Front\Visitor;

use App\Http\Traits\ControllerHelperTrait;
use App\Models\Decor;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController
{
	use ControllerHelperTrait;
	public function events(Request $request)
	{
		$list = Event::query();
		($search = $request->search) ? $list = $this->querySearch($list, ["name"], $search) : null;
		$list = $list->where('validation', 'validated')->with("decors")->where('end_date', '>=', now());
		$sort = $request->sort ?? 'created_at.desc';
		$parts = explode(".", $sort);
		$list->orderBy($parts[0], $parts[1]);
		$list = $list->paginate(12);
		$sortList = [
			"created_at.desc" => "Les plus récents",
			'created_at.asc'  => "Les plus anciens",
			'start_date.asc'  => "Les plus proches",
			'start_date.desc'  => "Les moins proches",
		];
		return view("visitor.pages.events", ["events" => $list ?? [], "search" => $request->search, "sort" => $sort, "sortList" => $sortList, "search_text" => "Rechercher des événements"]);
	}

	public function decors(Request $request)
	{
		$list = Decor::query();
		($search = $request->search) ? $list = $this->querySearch($list, ["name"], $search) : null;
		$decorList = $list->whereIn('validation', ['validated'])->where('start_use', '<=', now()->toDateString())->where('end_use', '>=', now()->toDateString())->with(["user", "event"]);
		$sort = $request->sort ?? 'created_at.desc';
		$parts = explode(".", $sort);
		$list->orderBy($parts[0], $parts[1]);
		$list = $list->paginate(12);
		$sortList = [
			"created_at.desc" => "Les plus récents",
			'created_at.asc'  => "Les plus anciens",
			'nb_use.asc'  => "utilisations croisant",
			'nb_use.desc'  => "utilisations décroisant",
			'end_use.asc'  => "Jours restants croisant",
			'end_use.desc'  => "Jours restants décroisant",
		];
		return view("visitor.pages.decors", ["decors" => $list ?? [], "search" => $request->search, "sort" => $sort, "sortList" => $sortList, "search_text" => "Rechercher des décors"]);
	}

	public function event_details(Request $request, $id)
	{
		$event_response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/event/" . $id,
			[
				"with_decors" => "true"
			]
		)->json();
		return view('visitor.pages.event-details', ['event' => $event_response["data"]["Event"]]);
	}

	public function use_decor(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/decor/" . $id,
			[
				"with_promoter<user" => "true",

			]
		)->json();
		return view('visitor.pages.decor-use', ["decor" => $response["data"]["Decor"]]);
	}
}
