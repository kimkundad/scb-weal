<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TtbController;
use App\Http\Controllers\Ttb2Controller;
use App\Http\Controllers\TPController;
use App\Http\Controllers\SrichanController;
use App\Http\Controllers\ToyataController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\OwndaysQuizController;

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

Auth::routes();

Route::domain('ttb.idx.co.th')->group(function () {
    Route::get('/', function () {
        return view('welcome'); // หรือ controller ก็ได้
    });
});


    Route::domain('owndays.ideavivat.com')->group(function () {

        Route::get('/', function () {
                return view('owndays.index'); // หรือ controller ก็ได้
        });

        Route::get('/intro', function () {
                return view('owndays.intro'); // หรือ controller ก็ได้
        });

        Route::get('/data', function () {
                return view('owndays.data'); // หรือ controller ก็ได้
        });

        Route::get('/intro_quiz', function () {
                return view('owndays.intro_quiz'); // หรือ controller ก็ได้
        });

        // Route::get('/quiz', function () {
        //         return view('owndays.quiz'); // หรือ controller ก็ได้
        // });

        Route::get('/finalQuiz', function () {
                return view('owndays.finalQuiz'); // หรือ controller ก็ได้
        });

        Route::get('/result', [OwndaysQuizController::class, 'showResult']);

        Route::get('/quiz', [QuizController::class, 'show']);

        Route::post('/quiz/submit', [OwndaysQuizController::class, 'submitQuiz']);

        Route::post('/submitForm', [OwndaysQuizController::class, 'storeUserInfo']);

        Route::post('/submitRating', [OwndaysQuizController::class, 'submitRating']);

        Route::get('/rating', function () {
                return view('owndays.rating'); // หรือ controller ก็ได้
        });

        Route::get('/final', function () {
                return view('owndays.final'); // หรือ controller ก็ได้
        });

    });



Route::middleware(['auth'])->group(function () {

    //  Route::domain('toyota.idx.co.th')->group(function () {

     //   Route::get('/', [App\Http\Controllers\ToyataController::class, 'index']);

    // Dashboard
    // Route::get('/admin/dashboard', [App\Http\Controllers\ToyataController::class, 'index'])
    //     ->name('dashboard.index');

    // Route::get('/members/create', [ToyataController::class, 'create'])->name('members.create');

    // // AJAX check-in
    // Route::post('/toyota/checkin', [ToyataController::class, 'checkIn'])->name('toyota.checkin');

    // Route::post('/toyota/checkin-toggle', [ToyataController::class, 'toggleCheckin'])
    // ->name('toyota.checkin.toggle');

    // Route::get('/toyota/edit',  [ToyataController::class, 'edit'])->name('toyota.edit');
    // Route::post('/toyota/update', [ToyataController::class, 'update'])->name('toyota.update');

    // Route::get('/members/create', [ToyataController::class, 'create'])->name('members.create');
    // Route::post('/members',        [ToyataController::class, 'store'])->name('members.store');

    // // Route::get('/toyota/instead/{spreadsheetId}/{sheetName}/{row}/{Name}', [ToyataController::class,'insteadForm'])
    // // ->name('toyota.instead.form');

    // Route::get(
    //     '/toyota/instead/{spreadsheetId}/{sheetName}/{row}/{Name?}',
    //     [ToyataController::class, 'insteadForm']
    // )->name('toyota.instead.form');

    // Route::post('/toyota/instead', [ToyataController::class,'insteadStore'])
    //     ->name('toyota.instead.store');

    //  });



    // Route::domain('srichandxbambam.com')->group(function () {
    //     Route::get('/', function () {
    //         return view('srichan.index'); // หรือ controller ก็ได้
    //     });
    // });

    // Route::get('/srichand/show-info', function () {
    //     return view('srichan.ans'); // เปลี่ยนชื่อไฟล์ Blade ตามที่ใช้จริง
    // })->name('showInfo');

    // Route::get('/verify_code/{code}', [SrichanController::class, 'verify']);

    // Route::post('/register_user', [SrichanController::class, 'registerUser']);

    // Route::get('/srichan_success', function () {
    //         return view('srichan.success'); // หรือ controller ก็ได้
    // });

});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::post('/search_cus', [SrichanController::class, 'search_cus']);

Route::get('/p2', function () {
    return view('tp.p2');
});

Route::get('/p3', function () {
    return view('tp.p3');
});

Route::post('/tp_step1', [TPController::class, 'postStep1']);
Route::post('/tp_step2', [TPController::class, 'postStep2']);
Route::post('/tp_step3', [TPController::class, 'postStep3']);

// ttb.idx.co.th → ไป path /
// Route::domain('ttb.idx.co.th')->group(function () {
//     Route::get('/', function () {
//         return view('ttb2.index'); // หรือ controller ก็ได้
//     });
// });

Route::domain('tp.ideavivat.com')->group(function () {
    Route::get('/', function () {
        return view('tp.index'); // หรือ controller ก็ได้
    });
});

// qanda.idx.co.th → ไป path /qanda
Route::domain('qanda.idx.co.th')->group(function () {
    Route::get('/', function () {
        return view('ttb3.index'); // หรือ controller ก็ได้
    });
});

// Route::get('/', function () {
//         return view('ttb3.index'); // หรือ controller ก็ได้
//     });

Route::get('/Notfound', function () {
    return view('ttb2.404');
});

Route::get('/confirm_user', function () {
    return view('ttb2.confirm');
});

Route::get('/ans', function (Illuminate\Http\Request $request) {
    $id = $request->query('id'); // ดึงค่า id จาก query string
    return view('ttb1.ans', ['id' => $id]);
});

Route::post('/auto_search', [Ttb2Controller::class, 'auto_search']);


Route::get('/ans_success', function () {
    return view('ttb3.success');
});

Route::get('/tp_ans_success', function () {
    return view('tp.success');
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



Route::post('/api_search', [EmployeeController::class, 'api_search']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/employee/search', [EmployeeController::class, 'search'])->name('employee.search');
Route::post('/employee/register', [EmployeeController::class, 'register'])->name('employee.register');

