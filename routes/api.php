<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OwnersController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\PaymentsController;
use App\Http\Controllers\Api\SalonsController;
use App\Http\Resources\SalonResource;
use App\Models\Salon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('owner', OwnersController::class);
Route::resource('user', UsersController::class);
Route::resource('pay', PaymentsController::class);
Route::resource('salon', SalonsController::class);

// Route::get('/salon/{id}', function($id) {
//     return new SalonResource(Salon::findOrFail($id));
// });

