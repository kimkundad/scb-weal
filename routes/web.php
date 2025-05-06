<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TtbController;
use App\Http\Controllers\Ttb2Controller;

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

// Route::get('/', function () {
//         return view('ttb3.index'); // หรือ controller ก็ได้
//     });

// ttb.idx.co.th → ไป path /
Route::domain('ttb.idx.co.th')->group(function () {
    Route::get('/', function () {
        return view('ttb2.index'); // หรือ controller ก็ได้
    });
});

// qanda.idx.co.th → ไป path /qanda
Route::domain('qanda.idx.co.th')->group(function () {
    Route::get('/', function () {
        return view('ttb3.index'); // หรือ controller ก็ได้
    });
});

Route::get('/Notfound', function () {
    return view('ttb2.404');
});

Route::get('/confirm_user', function () {
    return view('ttb2.confirm');
});

Route::get('/ans', function (Illuminate\Http\Request $request) {
    $id = $request->query('id'); // ดึงค่า id จาก query string
    return view('ttb3.ans', ['id' => $id]);
});

Route::post('/auto_search', [Ttb2Controller::class, 'auto_search']);


Route::get('/ans_success', function () {
    return view('ttb3.success');
});


Route::post('/post_submit', [Ttb2Controller::class, 'post_submit']);
Route::post('/post_ans', [Ttb2Controller::class, 'post_ans']);

Route::post('/post_ans_ttb3', [Ttb2Controller::class, 'post_ans_ttb3']);

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
