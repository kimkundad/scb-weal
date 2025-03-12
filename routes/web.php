<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', function () {
    return view('search');
});

Route::get('/result/{tableNumber}', function($tableNumber) {
    return view('result', compact('tableNumber'));
})->name('result');


Route::get('/afternoon', function () {
    return view('afternoon');
});

Auth::routes();

Route::post('/api_search', [EmployeeController::class, 'api_search']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/employee/search', [EmployeeController::class, 'search'])->name('employee.search');
Route::post('/employee/register', [EmployeeController::class, 'register'])->name('employee.register');
