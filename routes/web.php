<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ! Frontend Routes

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/purchase-admission-form', [HomeController::class, 'purchase'])->name('form.purchase');
Route::get('/school-fees-payment', [HomeController::class, 'showfees'])->name('fees.pay');
Route::post('/school-fees-payment', [HomeController::class, 'payfees'])->name('pay.fees');
Route::post('/student-admissions', [AdmissionController::class, 'store'])->name('admission.store');



// ! Backend Routes
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('backend.index');
    })->name('admin.index');

    // ! Students
    Route::resource('student', StudentController::class);
    Route::get('student/promote/{id}', [StudentController::class, 'ShowPromotionForm'])->name('student.showPromotion');
    Route::post('student/promote/{id}', [StudentController::class, 'promote'])->name('student.promote');

    // ! Subjects
    Route::resource('subject', SubjectController::class);

    // ! Levels
    Route::resource('level', LevelController::class);

    // ! Classes
    Route::resource('class', ClassController::class);
    Route::get('/assignSubject', [ClassController::class, 'assignSubjectCreate'])->name('class.subject');
    Route::post('/assignSubject', [ClassController::class, 'assignSubject'])->name('subject.assign');

    // ! Users
    Route::resource('user', UserController::class);

    // ! Permissions
    Route::resource('permission', PermissionController::class);

    // ! Roles
    Route::resource('role', RoleController::class);

    // ! Categories
    Route::resource('category', CategoryController::class);

    // ! Academic Sessions
    Route::resource('session', SessionController::class);

    // ! Parents
    Route::resource('parent', ParentsController::class);

    // ! Terms
    Route::resource('term', TermController::class);
    Route::get('/termtypes', [TermController::class, 'createTermType'])->name('termtype.create');
    Route::post('/termtypes', [TermController::class, 'storeTermType'])->name('termtype.store');
});
