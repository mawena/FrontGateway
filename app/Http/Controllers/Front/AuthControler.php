<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthControler
{
	public function login(Request $request)
	{
		$requestData = $request->all();
		$response = Http::post(config('app.url') . "/api/auth/login", $requestData)->dd()->json();
		if ($response["status"] == 200) {
			session(['userToken' => $response["data"]["userToken"]]);
			return redirect()->route("admin.user.index");
		}
		return redirect()->back()
			->withInput()
			->withErrors($response["errors"]);
	}

	public function logout()
	{
		session()->forget('userToken');
		return redirect()->route('admin.login');
	}
}
