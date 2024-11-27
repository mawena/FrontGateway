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
			url("/") . "/api/user",
			[
				"paginate" => "false",
				"in_profile" => "supervisor"
			]
		)->json();
		return view("pages.user.index", ["users" => $response["data"]]);
	}

	public function edit(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			url("/") . "/api/user/" . $id
		)->json();
		return view("pages.user.edit", ["users" => $response["data"]]);
	}

	public function store(Request $request)
	{
		$requestData = $request->all();
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->post(url("/") . "/api/user", $requestData)->json();
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
		])->delete(url("/") . "/api/user/" . $id)->json();
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
