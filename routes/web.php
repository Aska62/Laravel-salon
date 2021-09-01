<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OwnersController;
use App\Http\Controllers\SystemController;

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

Route::get('/', [UsersController::class, 'home'])->name('user.home');
Route::get('{salon_name}', [UsersController::class, 'detail'])->name('user.detail');
Route::get('{salon_name}/entry', [UsersController::class, 'entry'])->name('user.entry');
Route::post('{salon_name}/payment', [UsersController::class, 'payment'])->name('user.payment');
Route::post('{salon_name}/submit', [UsersController::class, 'submit'])->name('user.submit');
Route::get('{salon_name}/welcome', [UsersController::class, 'welcome'])->name('user.welcome');

Route::prefix('owners')->group(function() {
    Route::get('home', [OwnersController::class, 'ownerHome'])->name('owner.home');
    Route::get('create', [OwnersController::class, 'create'])->name('owner.create');
    Route::post('add', [OwnersController::class, 'addSalon'])->name('owner.submit');
    Route::get('thanks', [OwnersController::class, 'success'])->name('owner.thanks');
});

Route::prefix('system')->group(function() {
    Route::get('top', [SystemController::class, 'systemTop'])->name('system.top');
    Route::get('users', [SystemController::class, 'listUsers'])->name('system.users');
    Route::get('payments', [SystemController::class, 'paymentHistory'])->name('system.payments');
    Route::get('output', [SystemController::class, 'outputCSV'])->name('system.output');
});
