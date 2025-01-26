<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AutomaticExtractionGroupController;
use App\Http\Controllers\API\ConfigurationController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\ExtractionController;
use App\Http\Controllers\API\LaunchController;
use App\Http\Controllers\API\LovController;
use App\Http\Controllers\API\TaskScheduleController;
use App\Http\Controllers\API\ScriptController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AutomaticExtractionController;
use App\Http\Controllers\API\EnvironmentController;
use App\Http\Controllers\API\OperationController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\OperationProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
	Route::post("auth/login", "login");

	Route::middleware('auth:sanctum')->group(function () {
		Route::prefix("/auth")->name("auth.")->group(function () {
			Route::get('show', "show")->name("show");
			Route::delete('logout', "logout")->name("logout");
		});

		Route::prefix("department")->name("department.")->controller(DepartmentController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});

		Route::prefix("extraction")->name("extraction.")->controller(ExtractionController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::put("/sql/{id}", 'update_sql')->name("update_sql");
			Route::delete("{id}", 'destroy')->name("destroy");
		});

		Route::prefix("user")->name("user.")->controller(UserController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("/update-password", [UserController::class, "update_password"])->name("update-password");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});

		Route::prefix("task-schedule")->name("task-schedule.")->controller(TaskScheduleController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("configuration")->name("configuration.")->controller(ConfigurationController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("launch")->name("launch.")->controller(LaunchController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::put("/change-archiving/{id}", 'change_archiving')->name("change_archiving");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("script")->name("script.")->controller(ScriptController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("lov")->name("lov.")->controller(LovController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("service")->name("service.")->controller(ServiceController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::put("start/{id}", 'start')->name("start");
			Route::put("stop/{id}", 'stop')->name("stop");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("automatic-extraction-group")->name("automatic-extraction-group.")->controller(AutomaticExtractionGroupController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("/launch-all/{environment_id}", 'launch_all')->name("launch-all");
			Route::put("launch/{id}", 'launch')->name("launch");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("automatic-extraction")->name("automatic-extraction.")->controller(AutomaticExtractionController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("operation")->name("operation.")->controller(OperationController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("operation-product")->name("operation-product.")->controller(OperationProductController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
		Route::prefix("environment")->name("environment.")->controller(EnvironmentController::class)->group(function () {
			Route::get("/", 'index')->name("index");
			Route::get("{id}", 'show')->name("show");
			Route::post("/", 'store')->name("store");
			Route::put("{id}", 'update')->name("update");
			Route::put("duplicate/{id}", 'duplicate')->name("duplicate");
			Route::delete("{id}", 'destroy')->name("destroy");
		});
	});
});

Route::get("test", function () {});
