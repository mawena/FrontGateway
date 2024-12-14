<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class PaymentController
{
	public function index()
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/payment",
			["paginate" => "false"]
		)->json();

		$user_response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/user/".session("userData")["id"],
		)->json();
		return view("pages.payment.index", ["payments" => $response["data"], "user" => $user_response["data"]["User"]]);
	}

	public function show(Request $request, $id)
	{
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->get(
			config('app.url') . "/api/payment/" . $id,
			["with_user" => "true"]
		)->json();
		return view("pages.payment.show", ["payment" => $response["data"]["Payment"]]);
	}

	public function store(Request $request)
	{
		$requestData = $request->all();
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->post(config('app.url') . "/api/payment", $requestData)->json();
		if ($response["status"] == 201) {
			return Redirect::to($response["data"]["payment"]["payment_url"]);
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
			config('app.url') . "/api/payment/" . $id
		)->json();
		return view("pages.payment.edit", ["payment" => $response["data"]["Payment"]]);
	}

	public function update(Request $request, $id)
	{
		$requestData = $request->all();
		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . session('userToken'),
			'Accept' => 'application/json',
		])->put(config('app.url') . "/api/payment/" . $id, $requestData)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.payment.index");
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
		])->delete(config('app.url') . "/api/payment/" . $id)->json();
		if ($response["status"] == 200) {
			return redirect()->route("admin.payment.index");
		} else {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}
}
