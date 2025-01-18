<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController
{
	public function index()
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/user",
			[
				"paginate" => "false",
				"in_profile" => "supervisor-money_manager-event_planner"
			]
		)->json();
		return view("pages.user.index", ["users" => $response["data"]]);
	}

	public function show(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/user/" . $id
		)->json();
		return view("pages.user.show", ["user" => $response["data"]["User"]]);
	}


	public function edit(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/user/" . $id
		)->json();
		return view("pages.user.edit", ["user" => $response["data"]["User"]]);
	}

	public function update(Request $request, $id)
	{
		$requestData = $request->all();
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->put(config('app.url') . "/api/user/" . $id, $requestData)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.user.index");
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
		])->post(config('app.url') . "/api/user", $requestData)->json();
		if ($response["status"] == 201) {
			return redirect()->route("admin.user.index");
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
		])->delete(config('app.url') . "/api/user/" . $id)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.user.index");
		} else {
			dd($response);
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}
}
