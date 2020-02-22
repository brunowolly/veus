<?php

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
Route::group(['middleware' => 'apiJwt', 'prefix' => 'v1'], function () {
    // Route::get('users', 'Api\\UserController@index');
    /* ROTAS "/brands/" */

    /*
     * Isto será acessível via http://localhost:[porta]/brands/
     * O arquivo da classe será: app/Http/Controllers/BrandController.php
     */
    // Route::resource('brands', 'BrandController',
    //     ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

/* ROTAS "/gerentes/" */
    Route::group(['prefix' => 'brands'], function () {
        /*
         * Isto será acessível via http://localhost:[porta]/gerentes/
         * O arquivo da classe será: app/Http/Controllers/GerenteController.php
         */
        Route::get('/', 'BrandController@index');
        Route::get('/{id}', 'BrandController@show');
        Route::post('/', 'BrandController@store');
        Route::put('/{id}', 'BrandController@update');
        Route::delete('/{id}', 'BrandController@destroy');

    });

    Route::resource('products', 'ProductController',
        ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

});

Route::post('auth/login', 'Api\\AuthController@login');
// Route::post('logout', 'AuthController@logout');
// Route::post('refresh', 'AuthController@refresh');
//Route::post('me', 'AuthController@me');
Route::group(['prefix' => 'v2'], function () {
    Route::get('teste', function () {
        return "teste";
    });
});
