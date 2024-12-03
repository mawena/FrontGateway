<?php

namespace App\Http\Controllers\Front\Visitor;

use Illuminate\Http\Request;

class HomeController
{
    public function index()
	{
		// $decor_response = Http::withHeaders([
		// 	'Authorization' => 'Bearer ' . session('userToken'),
		// 	'Accept' => 'application/json',
		// ])->get(
		// 	config('app.url') . "/api/decor",
		// 	[
		// 		"paginate" => "false",
		// 		"with_event<promoter<user" => "true",
		// 	]
		// )->json();

		// $event_response = Http::withHeaders([
		// 	'Authorization' => 'Bearer ' . session('userToken'),
		// 	'Accept' => 'application/json',
		// ])->get(
		// 	config('app.url') . "/api/event",
		// 	[
		// 		"paginate" => "false",
		// 	]
		// )->json();
		// return view("pages.decor.index", ["decors" => $decor_response["data"], "events" => $event_response["data"]]);
		return view("visitor.base");
	}
}
