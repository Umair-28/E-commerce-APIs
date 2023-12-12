<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


 // Auth APIs

 Route::post('/register', [AuthController::class, 'register']);
 Route::post('/login', [AuthController::class, 'login']);
 Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

 // User Management (CRUD) APIs
 Route::middleware(['auth:sanctum', 'isAdmin'])->get('/users',[Controller::class, 'getAllUsers'] );
 Route::middleware(['auth:sanctum', 'isAdmin'])->get('/users/{id}', [Controller::class, 'getUserById']);
 Route::middleware(['auth:sanctum', 'isAdmin'])->delete('/users/{id}', [Controller::class, 'deleteUserById']);
 Route::middleware(['auth:sanctum', 'isAdmin'])->put('/users/{id}', [Controller::class, 'updateUserById']);


  // Product APIs

  Route::get('/products', [ProductController::class, 'getAllProducts']);

  Route::middleware(['auth:sanctum', 'isAdmin'])->post('/product', [ProductController::class, 'addProduct']);
  Route::middleware(['auth:sanctum', 'isAdmin'])->post('/product/{id}', [ProductController::class, 'updateProduct']);
  Route::middleware(['auth:sanctum', 'isAdmin'])->delete('/product/{id}', [ProductController::class, 'deleteProduct']);
  
  Route::middleware(['auth:sanctum'])->post('/orders', [OrderController::class, 'createOrder']);
  Route::middleware(['auth:sanctum', 'isAdmin'])->get('/orders', [OrderController::class, 'getAllOrders']);
  Route::middleware(['auth:sanctum', 'isAdmin'])->post('/orders/{id}', [OrderController::class, 'updateOrder']);
  Route::middleware(['auth:sanctum', 'isAdmin'])->get('/orders/{id}', [OrderController::class, 'getOrderById']);
  Route::middleware(['auth:sanctum', 'isAdmin'])->delete('/orders/{id}', [OrderController::class, 'deleteOrder']);
  