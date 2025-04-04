<?php

use App\Http\Controllers\Front\AuthControler;
use App\Http\Controllers\Front\ConfigurationController;
use App\Http\Controllers\Front\DecorController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\PromoterController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\Visitor\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('{any?}', function () {
	return view('application');
})->where('any', '.*');


use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::any('/SERVICE/{any}', function (Request $request, $any) {
	$url = "http://localhost:8888/{$any}";

	// Requête vers le vrai backend
	$response = Http::withoutVerifying() // utile si certificat SSL invalide
		->withHeaders($request->headers->all())
		->send($request->method(), $url, [
			'query' => $request->query(),
			'body' => $request->getContent(),
		]);

	return response($response->body(), $response->status())
		->withHeaders($response->headers());
})->where('any', '.*');
