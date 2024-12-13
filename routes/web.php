<?php

use App\Http\Controllers\Front\AuthControler;
use App\Http\Controllers\Front\DecorController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\PromoterController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\Visitor\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->as('visitor.')->group(function () {
	Route::get('/', function () {
		return redirect()->route("visitor.events");
	})->name('index');
	Route::get('/evenements', 'events')->name('events');
	Route::get('/evenements/details/{id}', 'event_details')->name('events.details');
	Route::get('/decors', 'decors')->name('decors');
	Route::get("/decors/use/{id}", "use_decor")->name("decors.use");

});

Route::prefix("admin")->name("admin.")->controller(AuthControler::class)->group(function () {
	Route::get('/', function () {
		return redirect()->route("admin.login");
	});
	Route::get("login", "login_view")->name("login");
	Route::post("login", "login")->name("post.login");
	Route::get("resgiter", "register_view")->name("register");
	Route::post("register", "register")->name("post.register");
	Route::middleware("user-token")->group(function () {
		Route::delete("logout", "logout")->name("logout");
		Route::prefix("/user")->name("user.")->controller(UserController::class)->group(function () {
			Route::get("/", "index")->name("index");
			Route::post("/", "store")->name("store");
			Route::get("/show/{id}", "show")->name("show");
			Route::get("/edit/{id}", "edit")->name("edit");
			Route::put("/{id}", "update")->name("update");
			Route::delete("/{id}", "destroy")->name("destroy");
		});
		Route::prefix("/promoter")->name("promoter.")->controller(PromoterController::class)->group(function () {
			Route::get("/", "index")->name("index");
			Route::post("/", "store")->name("store");
			Route::get("/show/{id}", "show")->name("show");
			Route::get("/edit/{id}", "edit")->name("edit");
			Route::put("/{id}", "update")->name("update");
			Route::delete("/{id}", "destroy")->name("destroy");
		});

		Route::prefix("/event")->name("event.")->controller(EventController::class)->group(function () {
			Route::get("/", "index")->name("index");
			Route::post("/", "store")->name("store");
			Route::get("/show/{id}", "show")->name("show");
			Route::get("/edit/{id}", "edit")->name("edit");
			Route::put("/{id}", "update")->name("update");
			Route::put("/change-validation/{id}", "change_validation")->name("change_validation");
			Route::delete("/{id}", "destroy")->name("destroy");
		});
		Route::prefix("/decor")->name("decor.")->controller(DecorController::class)->group(function () {
			Route::get("/", "index")->name("index");
			Route::post("/", "store")->name("store");
			Route::get("/show/{id}", "show")->name("show");
			Route::get("/edit/{id}", "edit")->name("edit");
			Route::put("/{id}", "update")->name("update");
			Route::put("/change-validation/{id}", "change_validation")->name("change_validation");
			Route::delete("/{id}", "destroy")->name("destroy");
		});
	});
});
