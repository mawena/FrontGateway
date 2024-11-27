<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventController
{
	public function index()
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
				url("/") . "/api/event",
				[
					"paginate" => "false"
				]
			)->json();
		return view("pages.event.index", ["events" => $response["data"]]);
	}

	public function edit(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
				url("/") . "/api/event/" . $id
			)->json();
		return view("pages.event.edit", ["user" => $response["data"]["Event"]]);
	}

	public function update(Request $request, $id)
	{
		$requestData = $request->all();
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->put(url("/") . "/api/event/" . $id, $requestData)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.event.index");
		} else {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}

	public function store(Request $request)
	{
		$requestData = $request->all();
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->post(url("/") . "/api/event", $requestData)->json();
		if ($response["status"] == 201) {
			return redirect()->route("admin.event.index");
		} else {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}

	public function destroy(Request $request, int $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->delete(url("/") . "/api/event/" . $id)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.event.index");
		} else {
			dd($response);
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}
}
