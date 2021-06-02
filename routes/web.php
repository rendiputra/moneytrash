<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationController;
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

Auth::routes();

Route::group(['middleware'=>'isUser'],function(){
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/types', [UserController::class, 'types_store'])->name('user.types.store');
        Route::post('/profile_account_address', [UserController::class, 'profile_account_address_store'])->name('user.profile_account.address.store');
        Route::get('/kocak/{id}', [UserController::class, 'profile_account_address_kocak'])->name('user.profile_account.address.kocak');
    });
});

Route::group(['middleware'=>'isDriver'],function(){
    Route::prefix('driver')->group(function () {
        Route::get('/', [DriverController::class, 'index'])->name('driver.index');
    });
});

Route::group(['middleware'=>'isAdmin'],function(){
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/garbages', [AdminController::class, 'garbage'])->name('admin.garbage');
        Route::post('/garbages', [AdminController::class, 'garbage_store'])->name('admin.garbage_store');
        Route::get('/banks', [AdminController::class, 'banks'])->name('admin.banks');
        Route::post('/banks', [AdminController::class, 'banks_store'])->name('admin.banks_store');
        Route::prefix('accounts')->group(function () {
            Route::get('/', [AdminController::class, 'list_account'])->name('admin.list_account');
            Route::get('/create', [AdminController::class, 'create_account'])->name('admin.create_account');
            Route::post('/create', [AdminController::class, 'create_account_store'])->name('admin.create_account.store');
            Route::get('/{id}', [AdminController::class, 'profile_account'])->name('admin.profile_account');
            Route::post('/{id}', [AdminController::class, 'profile_account_store'])->name('admin.profile_account_store');
            Route::post('/{id}/profile_account_address', [AdminController::class, 'profile_account_address_store'])->name('admin.profile_account.address.store');
        });
    });
});

Route::get('/{locale}')->name('dashboard');
Route::get('/{locale}/settings', [HomeController::class, 'settings'])->name('settings');
Route::post('/{llocale}/settings', [HomeController::class, 'settings_store'])->name('settings.store');

Route::prefix('location')->group(function () {
    Route::post('/province', [LocationController::class, 'province_store'])->name('province.store');
    Route::post('/city', [LocationController::class, 'city_store'])->name('city.store');
    Route::post('/district', [LocationController::class, 'district_store'])->name('district.store');
    Route::post('/village', [LocationController::class, 'village_store'])->name('village.store');
});

Auth::routes();
