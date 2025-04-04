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
