<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Models\Author;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

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
//Route::apiResource('books', BookController::class);

// Public route
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);;
Route::apiResource('genres', GenreController::class)->only(['index', 'show']);;
Route::apiResource('/books', BookController::class)->only(['index', 'show']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('/books', BookController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/me', [AuthController::class, 'me']);
});