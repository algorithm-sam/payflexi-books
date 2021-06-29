<?php

use App\Http\Controllers\BookController;
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

// Route::middleware('auth:api')->get('/', function (Request $request) {
//     // return $request->user();
// });

Route::get('/', function (Request $request) {
    return response()->json(['message' => 'Welcome to Books API'], 200);
});
Route::group([
    'namespace' => 'API',
], function () {

    Route::get('external-books', 'BookController@searchBook');
    Route::post('/books', 'BookController@store');

    Route::get('/books', 'BookController@index');

    Route::match(['patch', 'put'], '/books/{id}', 'BookController@update');
    Route::post('/books/{id}/update', 'BookController@update');
    Route::delete('/books/{id}', 'BookController@destroy');
    Route::post('/books/{id}/delete', 'BookController@destroy');


    Route::get('books/{id}', 'BookController@show');
});
