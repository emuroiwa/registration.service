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
/**Route for products */
Route::get('products', 'ProductController@index');

/**Route for auth API */
Route::post('auth', 'AuthController@auth');

/**Route for details user API */
Route::middleware('auth:api')->group(function(){
    Route::get('user', 'UserController@index');
    Route::get('user/products', 'UserController@show');
    Route::post('user/products', 'UserController@store');
    Route::delete('user/products/{sku}', 'UserController@destroy');
});
