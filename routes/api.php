<?php

use Illuminate\Http\Request;

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

Route::resource('countries', 'CountryController');
Route::resource('cities', 'CityController');
Route::resource('contact-types', 'ContactTypeController');
Route::resource('industry-types', 'IndustryTypeController');
Route::resource('clients', 'ClientController');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
