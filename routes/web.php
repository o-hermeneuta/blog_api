<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TagController;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('/articles')->group(function () {
    Route::get('/', [ArticleController::class,'index']);
    Route::namespace('articles-create')->get('/create', [ArticleController::class,'create']);
});

Route::prefix('/tag')->group(function () {
    Route::patch('/{article_id}', [ArticleController::class,'put_tag']);
    Route::delete('/{article_id}', [ArticleController::class,'remove_tag']);
});

Route::prefix('/article')->group(function () {
    Route::post('/', [ArticleController::class,'make']);
    Route::put('/{id}', [ArticleController::class,'edit']);
    Route::patch('/{id}/post', [ArticleController::class,'post']);
    Route::patch('/{id}/hide', [ArticleController::class,'hide']);
    Route::patch('/{id}/rate', [ArticleController::class,'rate']);
    Route::delete('/{id}', [ArticleController::class,'remove']);
});

Route::prefix('/user', function () {
    Route::resource('user', UserController::class);
});

Route::prefix('/tag', function () {
    Route::resource('user', TagController::class);
});
