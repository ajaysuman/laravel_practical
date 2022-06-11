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

Route::get('/', function () { echo "asdas";exit();
    return view('dashboard.customer');
//     return redirect()->action([App\Http\Controllers\CustomerController::class, 'index']);
  });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/showCustomer', [App\Http\Controllers\CustomerController::class, 'index'])->name('showCustomer');
Route::get('users', [App\Http\Controllers\CustomerController::class, 'index'])->name('users.index');

// for crud Route
Route::post('/addCustomer', [App\Http\Controllers\CustomerController::class, 'addCustomer'])->name('addCustomer');
Route::post('/editCustomer', [App\Http\Controllers\CustomerController::class, 'editCustomer'])->name('editCustomer');
Route::post('/updateCustomer', [App\Http\Controllers\CustomerController::class, 'updateCustomer'])->name('updateCustomer');

Route::get('/delete', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('delete');


