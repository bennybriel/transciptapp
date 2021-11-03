<?php

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
Route::prefix('v1')->group(function()
{
  //Route::post('login', [AuthController::class, 'signin']);
  //Route::get('/login', [App\Http\Controllers\AuthController::class, 'signin'])->name('signin');
 // Route::get('/AuthenticateMe/{u}/{p}', [App\Http\Controllers\SignInController::class, 'AuthenticateMe'])->name('AuthenticateMe');
  Route::get('/GetTranscript/{id}', [App\Http\Controllers\APIEndPointController::class, 'GetTranscript'])->name('GetTranscript');
  Route::get('/GetPaidTranscripts', [App\Http\Controllers\APIEndPointController::class, 'GetPaidTranscripts'])->name('GetPaidTranscripts');
  Route::get('/GetTotalCompleteApp', [App\Http\Controllers\APIEndPointController::class, 'GetTotalCompleteApp'])->name('GetTotalCompleteApp');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
