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

Route::get('v{version}/score', 'PopularityScoreController@show')->name('score.v2.show')->middleware('client');
Route::get('score', 'PopularityScoreController@show')->name('score.show')->middleware('client');

Route::get('get-token', function() {
    $guzzle = new GuzzleHttp\Client;

    $response = $guzzle->post('http://popularity-score.test/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'scope' => '*',
        ],
    ]);

    return json_decode((string) $response->getBody(), true)['access_token'];
});

