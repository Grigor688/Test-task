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
    Route::post('create_tag', [PostController::class, 'createTag']);
    Route::get('get_tag/{id}', [PostController::class, 'getTag']);
    Route::get('get_tags_list', [TagController::class, 'getList']);
    Route::get('get_categories_list', [CategoryController::class, 'getList']);
    Route::get('get_comments_list', [CommentController::class, 'getList']);
});