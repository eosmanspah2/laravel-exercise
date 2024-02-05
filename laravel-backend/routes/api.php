<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/product/newestVariant', [ProductController::class, 'newestVariant']);
Route::apiResource('product', ProductController::class);
Route::apiResource('productType', ProductTypeController::class);
Route::apiResource('variant', VariantController::class);


Route::post('login', [AuthenticationController::class, 'login']);
Route::post('logout', [AuthenticationController::class, 'logout'])->middleware("auth:sanctum");

Route::get('/product/{id}/allowedActions', [ProductController::class, 'allowedActions'])->name('product.allowedActions');
Route::put('/product/{id}/active', [ProductController::class, 'active'])->name('product.active');
Route::put('/product/{id}/draft', [ProductController::class, 'draft'])->name('product.draft');
Route::put('/product/{id}/deletes', [ProductController::class, 'hide'])->name('product.hide');
