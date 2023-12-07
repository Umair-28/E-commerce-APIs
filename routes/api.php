<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
 });






    // Auth APIs

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

    // User Management (CRUD) APIs
    Route::middleware(['auth:sanctum', 'isAdmin'])->get('/users',[Controller::class, 'getAllUsers'] );
    Route::middleware(['auth:sanctum', 'isAdmin'])->get('/users/{id}', [Controller::class, 'getUserById']);
    Route::middleware(['auth:sanctum', 'isAdmin'])->delete('/users/{id}', [Controller::class, 'deleteUserById']);
    Route::middleware(['auth:sanctum', 'isAdmin'])->put('/users/{id}', [Controller::class, 'updateUserById']);
    
