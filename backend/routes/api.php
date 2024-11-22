<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\authorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\Author;

Route::namespace('Api')->group(function () {
    // Public Api
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login/{provider}', [AuthController::class, 'redirectToProvider']);
    Route::get('/login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

    // Private Api with verify user login
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/verify_token', [AuthController::class, 'verifyToken']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('users' ,[UserController::class , 'index']);
        Route::post('users' ,[UserController::class , 'store']);
        Route::get('users/{id}' ,[UserController::class , 'show']);
        Route::put('users/{id}' ,[UserController::class , 'update']);
        Route::delete('users/{id}' ,[UserController::class , 'destroy']);
        Route::get('clients' ,[ClientController::class , 'index']);
        Route::get('clients/{client}' ,[ClientController::class , 'show']);
        Route::post('clients' ,[ClientController::class , 'store']);
        Route::put('clients' ,[ClientController::class , 'update']);
        Route::delete('clients/{client}' ,[ClientController::class , 'destroy']);
        Route::get('products' ,[ProductController::class , 'index']);
        Route::get('products/{product}' ,[ProductController::class , 'show']);
        Route::post('products',[ProductController::class , 'store']);
        Route::get('books' , [BookController::class , 'index']);
        Route::post('books',[BookController::class , 'store']);
        Route::put('books/{book}' ,[BookController::class , 'update']);
        Route::delete('books/{book}' ,[BookController::class , 'destroy']);
        Route::get('authors' , [authorController::class , 'index']);
        Route::post('authors' ,[authorController::class , 'store']);
        Route::put('authors/{author}' ,[authorController::class , 'update']);
        Route::delete('authors/{author}' ,[authorController::class , 'destroy']);

    });
});
