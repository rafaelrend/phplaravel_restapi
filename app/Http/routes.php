<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


/*

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth.basic'], function () {
    Route::get('/api/books', 'BookController@index');
    Route::get('/api/books/{id}', 'BookController@show');
    Route::post('/api/books', 'BookController@store');
    Route::put('/api/books/{id}', 'BookController@update');
    Route::delete('/api/books/{id}', 'BookController@destroy');
});

*/

  Route::group([
        'middleware' => [ 'cors']
    ], function ($router) {
         //Add you routes here, for example:
         //Route::apiResource('/posts','PostController');
		 Route::get('/author/', 'AuthorController@index');
         Route::get('/author/grid', 'AuthorController@grid');
         Route::post('/author/testpost', 'AuthorController@testpost');
         Route::put('/author/{id}', 'AuthorController@update');
         Route::post('/author', 'AuthorController@create');
         Route::delete('/author/{id}', 'AuthorController@destroy');



         Route::get('/book/', 'BookController@index');
         Route::get('/book/grid', 'BookController@grid');
         Route::post('/book/testpost', 'BookController@testpost');
         Route::put('/book/testpost', 'BookController@testpost');
         Route::put('/book/{id}', 'BookController@update');
         Route::post('/book', 'BookController@store');
         Route::delete('/book/{id}', 'BookController@destroy');

     });

