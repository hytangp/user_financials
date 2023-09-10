<?php

use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\FinancialController;
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
Route::middleware('throttle:api')->group(function(){
    Route::middleware('auth.api')->group(function () {
        Route::prefix('financials')->group(function(){
            Route::get('/', [FinancialController::class, 'index'])->name('api.financials.list');
            Route::post('/create', [FinancialController::class, 'store'])->name('api.financials.store');
            Route::post('/update', [FinancialController::class, 'update'])->name('api.financials.update');
            Route::post('/delete', [FinancialController::class, 'destroy'])->name('api.financials.delete');
        });
    });
    
    Route::post('/register', [UserAuthController::class,  'register']);
    Route::post('/login', [UserAuthController::class,  'login']);
});