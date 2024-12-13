<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConfigurationController
{
	public function index()
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/configuration",
			["paginate" => "false", "order_by_desc" => "id"]
		)->json();
		return view("pages.configuration.index", ["configurations" => $response["data"]]);
	}

	public function show(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/configuration/" . $id
		)->json();
		return view("pages.configuration.show", ["configuration" => $response["data"]["Configuration"]]);
	}

	public function store(Request $request)
	{
		$requestData = $request->all();
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->post(config('app.url') . "/api/configuration", $requestData)->json();
		if ($response["status"] == 201) {
			return redirect()->route("admin.configuration.index");
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
			config('app.url') . "/api/configuration/" . $id
		)->json();
		return view("pages.configuration.edit", ["configuration" => $response["data"]["Configuration"]]);
	}

	public function update(Request $request, $id)
	{
		$requestData = $request->all();
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->put(config('app.url') . "/api/configuration/" . $id, $requestData)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.configuration.index");
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
		])->delete(config('app.url') . "/api/configuration/" . $id)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.configuration.index");
		} else {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}
}
