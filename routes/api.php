<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ConfigurationController;
use App\Http\Controllers\API\DecorController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


// Route::any('GATEWAY/{any}', function (Request $request, $any) {
// 	$url = "http://localhost:8888/{$any}";

// 	// $response = Http::withoutVerifying()
// 	// 	->withHeaders($request->headers->all())
// 	// 	->send($request->method(), $url, [
// 	// 		'query' => $request->query(),
// 	// 		'body' => $request->getContent(),
// 	// 	]);

// 	// // Headers CORS personnalisés
// 	// $corsHeaders = [
// 	// 	'Access-Control-Allow-Origin' => '*',
// 	// 	'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
// 	// 	'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
// 	// ];

// 	// // Fusionner les headers de la réponse backend + CORS
// 	// // dd($response->body(), $response->status(), array_merge($response->headers(), $corsHeaders));
// 	// return response($response->body(), $response->status())
// 	// 	->withHeaders(array_merge($response->headers(), $corsHeaders));
// })->where('any', '.*');

Route::any('/GATEWAY/{any}', function (Request $request, $any) {
	$url = "http://localhost:8888/{$any}";
	$response = Http::withoutVerifying()
		->withHeaders($request->headers->all())
		->send($request->method(), $url, [
			'query' => $request->query(),
			'body' => $request->getContent(),
		]);

	// Headers CORS personnalisés
	$corsHeaders = [
		'Access-Control-Allow-Origin' => '*',
		'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
		'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
		'Content-Type' => 'application/json',
	];
	$response = response($response->body(), $response->status())
		->withHeaders($corsHeaders);
	return $response;
})->where('any', '.*');

Route::controller(AuthController::class)->group(function () {
	Route::post("auth/login", "login");
	Route::post("auth/register", "register");


	Route::post('/manage-project', [ProjectController::class, 'handleProject']);

	Route::middleware('auth:sanctum')->group(function () {
		Route::prefix("/auth")->name("auth.")->group(function () {
			Route::get('show', "show")->name("show");
			Route::delete('logout', "logout")->name("logout");
		});

		Route::prefix("user")->name("user.")->controller(UserController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("/update-password", [UserController::class, "update_password"])->name("update-password");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});

		// Route::prefix("event")->name("event.")->controller(EventController::class)->group(function () {
		// 	Route::get("/", 'index')->name("index")->withoutMiddleware('auth:sanctum');
		// 	Route::get("{id}", 'show')->name("show")->withoutMiddleware('auth:sanctum');
		// 	Route::post("/", 'store')->name("store");
		// 	Route::put("{id}", 'update')->name("update");
		// 	Route::put("/change-validation/{id}", 'change_validation')->name("change_validation");
		// 	Route::delete("{id}", 'destroy')->name("destroy");
		// });
		// Route::prefix("decor")->name("decor.")->controller(DecorController::class)->group(function () {
		// 	Route::get("/", 'index')->name("index")->withoutMiddleware('auth:sanctum');
		// 	Route::get("/{id}", 'show')->name("show")->withoutMiddleware('auth:sanctum');
		// 	Route::post("/", 'store')->name("store");
		// 	Route::put("/change-validation/{id}", 'change_validation')->name("change_validation");
		// 	Route::put("/use/{id}", 'use')->name("use")->withoutMiddleware("auth:sanctum");
		// 	Route::put("/{id}", 'update')->name("update");
		// 	Route::delete("/{id}", 'destroy')->name("destroy");
		// });
		// Route::prefix("configuration")->name("configuration.")->controller(ConfigurationController::class)->group(function () {
		// 	Route::get("/", 'index')->name("index");
		// 	Route::get("/{id}", 'show')->name("show");
		// 	Route::post("/", 'store')->name("store");
		// 	Route::put("/{id}", 'update')->name("update");
		// 	Route::delete("/{id}", 'destroy')->name("destroy");
		// });
		// Route::prefix("payment")->name("payment.")->controller(PaymentController::class)->group(function () {
		// 	Route::get("/", 'index')->name("index");
		// 	Route::get("/{id}", 'show')->name("show");
		// 	Route::post("/callback", "callback")->name("callback");
		// 	Route::post("/", 'store')->name("store");
		// });
	});
});
