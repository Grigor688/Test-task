<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CategoryController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('register', [AuthController::class, 'register']);
Route::group(['middleware' => 'api','jwt.auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('post', PostController::class);
    //  USE TAG FROM POST
    Route::post('create_tag', [PostController::class, 'createTag']);
//  GET POSTS OF TAG AND HIS TAGS
    Route::get('get_tag/{id}', [PostController::class, 'getTag']);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('comments', CommentController::class);
});
