<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DecorController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
	Route::post("auth/login", "login");

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

		Route::prefix("decor")->name("decor.")->controller(DecorController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
	});
});
