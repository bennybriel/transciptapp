<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Auth::routes();
//Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
//Route::get('dashboard', 'App\Http\Controllers\DashboardController@dashboard')->middleware('auth');
Route::get('/ApplyNow', [App\Http\Controllers\DashboardController::class, 'ApplyNow'])->name('applyNow');
Route::post('/ConfirmMatricNo', [App\Http\Controllers\DashboardController::class, 'ConfirmMatricNo'])->name('ConfirmMatricNo');
Route::get('/GetState/{id}', [App\Http\Controllers\DashboardController::class, 'GetState'])->name('GetState');
Route::post('/DisplayResult', [App\Http\Controllers\DashboardController::class, 'DisplayResult'])->name('DisplayResult');
Route::get('/TrackingNow', [App\Http\Controllers\DashboardController::class, 'TrackingNow'])->name('trackApp');
Route::post('/TrackApplication', [App\Http\Controllers\DashboardController::class, 'TrackApplication'])->name('TrackApplication');

Route::get('/ShowTranscript', [App\Http\Controllers\DashboardController::class, 'ShowTranscript'])->name('showTranscript');
#Pay Now
Route::get('/PayNow/{id}/{prod}/{email}/{name}/{mat}', [App\Http\Controllers\PaymentController::class, 'PayNow'])->name('PayNow');

Route::get('/DataInfo', [App\Http\Controllers\DashboardController::class, 'DataInfo'])->name('dataInfo');
Route::post('/DataInfos', [App\Http\Controllers\DashboardController::class, 'DataInfos'])->name('DataInfos');
#Registration Confirmation
Route::get('/RegConfirmation', [App\Http\Controllers\DashboardController::class, 'RegConfirmation'])->name('registrationConfrimationPage');
Route::get('/CheckPay', [App\Http\Controllers\PaymentController::class, 'CheckPay'])->name('checkPaymentStatus');
Route::post('/CheckPayStatus', [App\Http\Controllers\PaymentController::class, 'CheckPayStatus'])->name('CheckPayStatus');
Route::get('/DownloadTranscriptInfo', [App\Http\Controllers\PaymentController::class, 'DownloadTranscriptInfo'])->name('DownloadTranscriptInfo');

Route::get('/CompleteApp', [App\Http\Controllers\DashboardController::class, 'CompleteApp'])->name('completeApp');
Route::post('/CompleteApplications', [App\Http\Controllers\DashboardController::class, 'CompleteApplications'])->name('CompleteApplications');
#GetTranscriptIDs
Route::get('/GetTranscriptID', [App\Http\Controllers\DashboardController::class, 'GetTranscriptID'])->name('getTranscriptID');
Route::post('/GetTranscriptIDs', [App\Http\Controllers\DashboardController::class, 'GetTranscriptIDs'])->name('GetTranscriptIDs');



