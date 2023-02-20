<?php

use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\InvoiceTaskController;
use App\Http\Controllers\API\SummaryController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\API\LoginController@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'projects' => ProjectController::class,
        'invoices' => InvoiceController::class,
        'invoice_tasks' => InvoiceTaskController::class
    ]);
    Route::get('/summary', SummaryController::class);
});
