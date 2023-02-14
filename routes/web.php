<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceTaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['admin', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('projects', ProjectController::class)
    ->missing(function (Request $request){
        return Redirect::route('projects.index');
});
Route::resource('invoices', InvoiceController::class)
    ->missing(function (Request $request){
        return Redirect::route('invoices.index');
    });
Route::resource('invoice_tasks', InvoiceTaskController::class)
    ->missing(function (Request $request){
        return Redirect::route('invoice_tasks.index');
    });

Route::get('/result', \App\Http\Controllers\ResultController::class)->middleware(['admin', 'verified']);

require __DIR__.'/auth.php';
