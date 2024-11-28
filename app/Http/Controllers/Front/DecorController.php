<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DecorController
{
	public function index()
	{
		$decor_response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/decor",
			[
				"paginate" => "false",
				"with_event<promoter<user" => "true",
			]
		)->json();

		$event_response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/event",
			[
				"paginate" => "false",
			]
		)->json();
		return view("pages.decor.index", ["decors" => $decor_response["data"], "events" => $event_response["data"]]);
	}
	public function store(Request $request)
	{
		$requestData = $request->all();
		$image = $request->file('file');
		$imageContent = file_get_contents($image->getPathname());
		$requestData['file'] = 'data:' . $image->getMimeType() . ';base64,' . base64_encode($imageContent);
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->post(config('app.url') . "/api/decor", $requestData)->json();
		if ($response["status"] == 201) {
			return redirect()->route("admin.decor.index");
		} else {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}

	public function edit(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/decor/" . $id,
			[
				"with_event" => "true",
			]
		)->json();
		$event_response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/event",
			[
				"paginate" => "false",
			]
		)->json();
		return view("pages.decor.edit", ["decor" => $response["data"]["Decor"], "events" => $event_response["data"]]);
	}

	public function update(Request $request, $id)
	{
		$requestData = $request->all();
		if (isset($requestData["poster"])) {
			$image = $request->file('file');
			$imageContent = file_get_contents($image->getPathname());
			$requestData['file'] = 'data:' . $image->getMimeType() . ';base64,' . base64_encode($imageContent);
		}
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->put(config('app.url') . "/api/decor/" . $id, $requestData)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.decor.index");
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
		])->delete(config('app.url') . "/api/decor/" . $id)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.decor.index");
		} else {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}
}
