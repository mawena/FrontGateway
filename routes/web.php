<?php

use App\Http\Controllers\Front\AuthControler;
use App\Http\Controllers\Front\PromoterController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

Route::prefix("/")->group(function () {
	Route::prefix("admin")->name("admin.")->controller(AuthControler::class)->group(function () {
		Route::get("login", function () {
			return view("Auth.login");
		});
		Route::post("login", "login");
		Route::prefix("/user")->name("user.")->controller(UserController::class)->group(function () {
			Route::get("/", "index")->name("index");
			Route::post("/", "store")->name("store");
			Route::delete("/{id}", "destroy")->name("destroy");
		});
		Route::prefix("/promoter")->name("promoter.")->controller(PromoterController::class)->group(function () {
			Route::get("/", "index")->name("index");
			Route::post("/", "store")->name("store");
			Route::delete("/{id}", "destroy")->name("destroy");
		});
	});
});
