<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PromoterController
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
				"in_profile" => "promoter",
				"with_promoter" => "true"
			]
		)->json();
		return view("pages.promoter.index", ["users" => $response["data"]]);
	}

	public function store(Request $request)
	{
		$requestData = $request->all();
		$requestData["promoter"] = [
			"structure" => $requestData["promoter_structure"],
			"phone_number" => $requestData["promoter_phone_number"],
			"birth_date" => $requestData["promoter_birth_date"],
			"sex" => $requestData["promoter_sex"],
		];
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->post(url("/") . "/api/user", $requestData)->json();
		if ($response["status"] == 201) {
			return redirect()->route("admin.promoter.index");
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
			url("/") . "/api/user/" . $id,
			[
				"with_promoter" => "true"
			]
		)->json();
		return view("pages.promoter.edit", ["promoter" => $response["data"]["User"]]);
	}

	public function update(Request $request, $id)
	{
		$requestData = $request->all();
		$requestData["promoter"] = [
			"structure" => $requestData["promoter_structure"],
			"phone_number" => $requestData["promoter_phone_number"],
			"birth_date" => $requestData["promoter_birth_date"],
			"sex" => $requestData["promoter_sex"],
		];
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->put(url("/") . "/api/user/" . $id, $requestData)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.promoter.index");
		} else {
			dd($response);
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
			return redirect()->route("admin.promoter.index");
		} else {
			dd($response);
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}
}
