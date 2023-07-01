<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('account')->group(function () {
    Route::post('/getList', [App\Http\Controllers\AccountInfoController::class, 'getList'])->name('account.getList');
    Route::post('/deleteBatch', [App\Http\Controllers\AccountInfoController::class, 'deleteBatch'])->name(
        'account.deleteBatch'
    );
    Route::post('/import', [App\Http\Controllers\AccountInfoController::class, 'import'])->name('account.import');
    Route::get('/export', [App\Http\Controllers\AccountInfoController::class, 'export'])->name('account.export');
});

Route::resource('/account', App\Http\Controllers\AccountInfoController::class);