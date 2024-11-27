<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthControler
{
	public function login(Request $request)
	{
		$requestData = $request->all();
		$response = Http::post(url("/") . "/api/auth/login", $requestData)->json();
		if ($response["status"] == 200) {
			session(['userToken' => $response["data"]["userToken"]]);
			return redirect()->route("admin.user.index");
		} else {
			return redirect()->back()
				->withInput()
				->withErrors($response["errors"]);
		}
	}

	public function logout()
	{
		session()->forget('userToken');
		return redirect()->route('admin.login');
	}
}
