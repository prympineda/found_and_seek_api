<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResources([
    'devices' => 'Api\DeviceController',
]);

Route::get('devices','Api\DeviceController@index');
Route::post('devices','Api\DeviceController@store');
Route::post('devices/{id}','Api\DeviceController@update');
Route::delete('devices','Api\DeviceController@destroy');