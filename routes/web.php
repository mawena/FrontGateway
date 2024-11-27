<?php

use App\Http\Controllers\Front\AuthControler;
use App\Http\Controllers\Front\DecorController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\PromoterController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
	return redirect()->route("admin.login");
});


Route::prefix("/")->group(function () {
	Route::prefix("admin")->name("admin.")->controller(AuthControler::class)->group(function () {
		Route::get('/', function () {
			return redirect()->route("admin.login");
		});
		Route::get("login", function () {
			return view("Auth.login");
		})->name("login");
		Route::post("login", "login")->name("post.login");
		Route::middleware("user-token")->group(function () {
			Route::delete("logout", "logout")->name("logout");
			Route::prefix("/user")->name("user.")->controller(UserController::class)->group(function () {
				Route::get("/", "index")->name("index");
				Route::post("/", "store")->name("store");
				Route::get("/edit/{id}", "edit")->name("edit");
				Route::put("/{id}", "update")->name("update");
				Route::delete("/{id}", "destroy")->name("destroy");
			});
			Route::prefix("/promoter")->name("promoter.")->controller(PromoterController::class)->group(function () {
				Route::get("/", "index")->name("index");
				Route::post("/", "store")->name("store");
				Route::get("/edit/{id}", "edit")->name("edit");
				Route::put("/{id}", "update")->name("update");
				Route::delete("/{id}", "destroy")->name("destroy");
			});


			Route::prefix("/event")->name("event.")->controller(EventController::class)->group(function () {
				Route::get("/", "index")->name("index");
				Route::post("/", "store")->name("store");
				Route::get("/edit/{id}", "edit")->name("edit");
				Route::put("/{id}", "update")->name("update");
				Route::delete("/{id}", "destroy")->name("destroy");
			});
			Route::prefix("/decor")->name("decor.")->controller(DecorController::class)->group(function () {
				Route::get("/", "index")->name("index");
				Route::post("/", "store")->name("store");
				Route::get("/edit/{id}", "edit")->name("edit");
				Route::put("/{id}", "update")->name("update");
				Route::delete("/{id}", "destroy")->name("destroy");
			});
		});
	});
});
