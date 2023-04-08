<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NationalitiesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FamilyListController;

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

    Route::prefix('customer')->group(function () {
        Route::get('', [CustomerController::class, 'index'])->name('getCustomer');
        Route::get('/get-data', [CustomerController::class, 'getDataCustomer'])->name('getDataCustomer');
        Route::get('/create', [CustomerController::class, 'create'])->name('createCustomer');
        Route::post('/create', [CustomerController::class, 'store'])->name('createCustomer');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('updateCustomer');
        Route::put('/edit/{id}', [CustomerController::class, 'update'])->name('updateCustomer');
        Route::delete('/delete/{id}', [CustomerController::class, 'destroy'])->name('deleteCustomer');
    });

    Route::prefix('family-list')->group(function () {
        Route::get('', [FamilyListController::class, 'index'])->name('getFamilyList');
        Route::get('/get-data', [FamilyListController::class, 'getDataFamilyList'])->name('getDataFamilyList');
        Route::get('/{id}', [FamilyListController::class, 'show'])->name('showFamilyList');
        Route::get('/create', [FamilyListController::class, 'create'])->name('createFamilyList');
        Route::post('/create', [FamilyListController::class, 'store'])->name('createFamilyList');
        Route::get('/edit/{id}', [FamilyListController::class, 'edit'])->name('updateFamilyList');
        Route::put('/edit/{id}', [FamilyListController::class, 'update'])->name('updateFamilyList');
        Route::delete('/delete/{id}', [FamilyListController::class, 'destroy'])->name('deleteFamilyList');
    });


});
