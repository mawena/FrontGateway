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
		$list = $list->where('validation', 'validated')->with("decors")->where('end_date', '>', now())->paginate(12);
		return view("visitor.pages.events", ["events" => $list ?? [], "search" => $request->$search]);
	}

	public function decors()
	{
		$query = Decor::query();
		$decorList = $query->whereIn('validation', ['validated'])->where('end_use', '>', now())->with(["user", "event"])->paginate(12);
		return view("visitor.pages.decors", ["decors" => $decorList ?? []]);
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
