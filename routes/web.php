<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('v2/score', 'PopularityScoreV2Controller@show')->name('score.v2.show');
Route::get('score', 'PopularityScoreV1Controller@show')->name('score.show');

