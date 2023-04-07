<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NationalitiesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/layouts', function () {
    return view('layouts.app');
});



Route::prefix('booking-to-go')->group(function () {

    Route::prefix('nationality')->group(function () {
        Route::get('', [NationalitiesController::class, 'index'])->name('getNationality');
        Route::get('/get-data', [NationalitiesController::class, 'getDataNationalities'])->name('getDataNationalities');
        Route::get('/create', [NationalitiesController::class, 'create'])->name('createNationality');
        Route::post('/create', [NationalitiesController::class, 'store'])->name('createNationality');
        Route::get('/edit/{id}', [NationalitiesController::class, 'edit'])->name('updateNationality');
        Route::put('/edit/{id}', [NationalitiesController::class, 'update'])->name('updateNationality');
        Route::delete('/delete/{id}', [NationalitiesController::class, 'destroy'])->name('deleteNationality');
    });


});
