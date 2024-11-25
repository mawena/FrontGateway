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
		])->get(url("/") . "/api/user"
		,[
			"paginate" => "false",
			"in_profile" => "supervisor"
		]
		)->json();
		return view("pages.user.index", ["users" => $response["data"]]);
	}
}
