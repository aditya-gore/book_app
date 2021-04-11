<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\GenresController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [UserController::class, 'register']);

Route::post('login', [UserController::class, 'login']);

Route::post('addBook', [BooksController::class, 'addBook']);
Route::get('list', [BooksController::class, 'list']);
Route::get('getNumberInStock/{id}', [BooksController::class, 'getNumberInStock']);
Route::get('incrementStock/{id}', [BooksController::class, 'incrementStock']);
Route::get('decrementStock/{id}', [BooksController::class, 'decrementStock']);

Route::get('getBook/{id}', [BooksController::class, 'getBook']);
Route::delete('delete/{id}', [BooksController::class, 'delete']);
Route::put('saveBook/{id}', [BooksController::class, 'saveBook']);

Route::get('getReaderHistory', [HistoryController::class, 'getReaderHistory']);
Route::get('isReading/{userId}', [HistoryController::class, 'isReading']);
Route::get('issueBook/{bookId}', [HistoryController::class, 'issueBook']);
Route::get('addReaderHistory/{userId}', [HistoryController::class, 'addReaderHistory']);

Route::get('getGenres', [GenresController::class, 'getGenres']);

Route::get('getUserById/{id}', [UserController::class, 'getUserById']);
Route::put('makeAdmin/{email}', [UserController::class, 'makeAdmin']);
Route::delete('deleteUser/{email}', [UserController::class, 'deleteUser']);
