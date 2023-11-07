<?php
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ClinicHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users.appointments', AppointmentsController::class);
    Route::apiResource('users.clinic_histories', ClinicHistoryController::class);
});