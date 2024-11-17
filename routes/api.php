<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:sanctum')->group(function () {


	Route::prefix("user")->name("user.")->controller(UserController::class)->group(function () {
		Route::get("/", 'index')->name("index");
		Route::get("{id}", 'show')->name("show");
		Route::post("/", 'store')->name("store");
		Route::put("/update-password", [UserController::class, "update_password"])->name("update-password");
		Route::put("{id}", 'update')->name("update");
		Route::delete("{id}", 'destroy')->name("destroy");
	});
});
