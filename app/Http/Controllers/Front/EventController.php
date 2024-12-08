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
			config('app.url') . "/api/event",
			[
				"paginate" => "false",
				"promoter_id" => session("userData")["id"]
			]
		)->json();
		return view("pages.event.index", ["events" => $response["data"]]);
	}

	public function show(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/event/" . $id
		)->json();
		return view("pages.event.show", ["event" => $response["data"]["Event"]]);
	}

	public function store(Request $request)
	{
		$requestData = $request->all();
		if (isset($requestData["poster"])) {
			$image = $request->file('poster');
			$imageContent = file_get_contents($image->getPathname());
			$requestData['poster'] = 'data:' . $image->getMimeType() . ';base64,' . base64_encode($imageContent);
		}
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->post(config('app.url') . "/api/event", $requestData)->json();
		if ($response["status"] == 201) {
			return redirect()->route("admin.event.index");
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
			config('app.url') . "/api/event/" . $id
		)->json();
		return view("pages.event.edit", ["event" => $response["data"]["Event"]]);
	}

	public function update(Request $request, $id)
	{
		$requestData = $request->all();
		if (isset($requestData["poster"])) {
			$image = $request->file('poster');
			$imageContent = file_get_contents($image->getPathname());
			$requestData['poster'] = 'data:' . $image->getMimeType() . ';base64,' . base64_encode($imageContent);
		}
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->put(config('app.url') . "/api/event/" . $id, $requestData)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.event.index");
		} else {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}

	public function change_validation(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->put(config('app.url') . "/api/event/change-validation/" . $id, $request->all())->json();
		if ($response["status"] == 200) {
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
		])->delete(config('app.url') . "/api/event/" . $id)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.event.index");
		} else {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}
}
