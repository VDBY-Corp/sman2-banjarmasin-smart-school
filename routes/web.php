<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dashboard\Admin\MasterData\StudentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Dashboard\Admin\MasterData\GradeController;
use App\Http\Controllers\Dashboard\Admin\MasterData\StudentController as AdminMasterDataStudentController;
use App\Http\Controllers\Dashboard\Admin\MasterData\TeacherController as AdminMasterDataTeacherController;
use App\Http\Controllers\Dashboard\Admin\MasterData\ViolationCategoryController as AdminViolationCategoryController;

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
    // redirect to login page
    return redirect('/auth/login');
});


// AUTH
Route::group(['prefix' => 'auth'], function () {
    // LOGIN
    Route::group([
        'middleware' => 'guest:admin,teacher',
    ], function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    // LOGOUT
    Route::group([
        'middleware' => 'auth:admin,teacher',
    ], function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});


// DASHBOARD
Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
], function () {

    // ADMIN
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'auth:admin',
        'as' => 'admin.',
    ], function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('home');

        Route::group([
            'prefix' => 'master-data',
            'as' => 'master.',
        ], function () {
            Route::apiResource('student', AdminMasterDataStudentController::class);
            Route::get('teacher', [AdminMasterDataTeacherController::class, 'index'])->name('teacher');
            Route::apiResource('violation', AdminViolationCategoryController::class);
        });
    });

    // TEACHER
    Route::group([
        'prefix' => 'teacher',
        'middleware' => 'auth:teacher',
        'as' => 'teacher.',
    ], function () {
        Route::get('/', function () {
            return view('pages.dashboard');
        })->name('home');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Teacher
Route::middleware('auth:teacher')->prefix('teacher')->group(function () {
    Route::get('/dashboard', function () {
        return view('teacher-dashboard');
    })->name('teacher.dashboard');
});


// Import excel
Route::get('/import-student', [StudentController::class, 'importView'])->name('import-view');
Route::post('/import-student', [StudentController::class, 'importStudent'])->name('importStudent');
Route::get('/export-users', [StudentController::class, 'exportUsers'])->name('export-users');

require __DIR__.'/auth.php';
