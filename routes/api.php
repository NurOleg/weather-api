<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemperatureController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('temperature', [TemperatureController::class, 'getTemperature']);
Route::get('average-temperature', [TemperatureController::class, 'getAvgTemperature']);
Route::get('temperature/popular', [TemperatureController::class, 'getPopularTemperature']);
