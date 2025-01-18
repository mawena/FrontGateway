<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthControler
{
	public function login_view(Request $request)
	{
		if (session('userToken') && session('userData')) {
			return redirect()->route(
				[
					"admin" => "admin.user.index",
					"supervisor" => "admin.promoter.index",
					"money_manager" => "admin.payment.index",
					"event_planner" => "admin.event.index",
					"promoter" => "admin.event.index",
					"visitor" => "admin.event.index",
				][session("userData")["profile"]]
			);
		}
		return view("auth.login");
	}
	public function login(Request $request)
	{
		$requestData = $request->all();
		$response = Http::post(config('app.url') . "/api/auth/login", $requestData)->json();
		if ($response["status"] != 200) {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
		session([
			'userToken' => $response["data"]["userToken"],
			"userData" => $response["data"]["user"],
		]);

		return redirect()->route(
			[
				"admin" => "admin.user.index",
				"supervisor" => "admin.promoter.index",
				"money_manager" => "admin.payment.index",
				"event_planner" => "admin.event.index",
				"promoter" => "admin.event.index",
				"visitor" => "admin.event.index",
			][$response["data"]["user"]["profile"]]
		);
	}

	public function register_view(Request $request)
	{
		if (session('userToken') && session('userData')) {
			return redirect()->route(
				[
					"admin" => "admin.user.index",
					"supervisor" => "admin.promoter.index",
					"promoter" => "admin.event.index",
				][session("userData")["profile"]]
			);
		}
		return view("auth.register");
	}

	public function register(Request $request)
	{
		$requestData = $request->all();
		$response = Http::post(config('app.url') . "/api/auth/register", $requestData)->json();
		if ($response["status"] != 201) {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
		session([
			'userToken' => $response["data"]["user"]["userToken"],
			"userData" => $response["data"]["user"],
		]);
		return redirect()->route(
			[
				"admin" => "admin.user.index",
				"supervisor" => "admin.promoter.index",
				"promoter" => "admin.event.index",
			][$response["data"]["user"]["profile"]]
		);
	}

	public function logout()
	{
		session()->forget('userToken');
		session()->forget('userData');
		return redirect()->route('admin.login');
	}
}
