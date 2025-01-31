<?php

namespace App\Http\Controllers\Front\Visitor;

use App\Models\Decor;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController
{
	public function events()
	{
		$query = Event::query();
		$eventList = $query->where('validation', 'validated')->with("decors")->where('end_date', '>', now())->paginate(12);
		return view("visitor.pages.events", ["events" => $eventList ?? []]);
	}

	public function decors()
	{
		$query = Decor::query();
		$decorList = $query->where('validation', 'validated')->with(["user", "event"])->whereIn('validation', ['validated', 'pending'])->where('end_use', '>', now())->paginate(12);
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
