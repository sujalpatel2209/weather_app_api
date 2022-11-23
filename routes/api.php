<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {

    Route::controller(AuthController::class)->prefix('auth')->group(function (){

        Route::post('signup', 'signUp');
        Route::post('signin', 'signIn');
    });

    Route::controller(WeatherController::class)->middleware('jwt.verify')->prefix('weather')->group(function (){

        Route::post('store_record', 'storeRecord');
        Route::get('fetch_weather_histories', 'fetchWeatherHistories');
    });
});
