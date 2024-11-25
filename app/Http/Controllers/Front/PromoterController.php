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
		])->get(url("/") . "/api/user"
		,[
			"paginate" => "false",
			"in_profile" => "promoter"
		]
		)->json();
		return view("pages.promoter.index", ["users" => $response["data"]]);
	}
}
