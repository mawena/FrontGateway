<?php

namespace App\Http\Controllers\Front\Visitor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController
{
	public function events()
	{
		$event_response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/event",
			[
				"paginate" => "false",
				"with_decors" => "true",
				"validation" => "validated",
			]
		)->json();
		return view("visitor.pages.events", ["events" => $event_response["data"] ?? []]);
	}

	public function decors()
	{
		$decor_response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/decor",
			[
				"paginate" => "false",
				"with_event<promoter<user" => "true",
				"validation" => "validated",
			]
		)->json();
		return view("visitor.pages.decors", ["decors" => $decor_response["data"] ?? []]);
	}

	public function event_details(Request $request, $id)
	{
		$event_response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/event/" . $id,
			[
				"paginate" => "false",
				"with_decors" => "true"
			]
		)->json();
		return view('visitor.pages.event-details', ['event' => $event_response["data"]["Event"]]);
	}

	public function use_decor(Request $request, $id){
		return view('visitor.pages.decor-use');
	}
}
