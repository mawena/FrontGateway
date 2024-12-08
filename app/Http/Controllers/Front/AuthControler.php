<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthControler
{
	public function login(Request $request)
	{
		$requestData = $request->all();
		$response = Http::post(config('app.url') . "/api/auth/login", $requestData)->json();
		if ($response["status"] == 200) {
			session([
				'userToken' => $response["data"]["userToken"],
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
		return redirect()->back()
			->withInput()
			->withErrors($response["errors"]);
	}

	public function logout()
	{
		session()->forget('userToken');
		session()->forget('userData');
		return redirect()->route('admin.login');
	}
}