<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AdmissionManagementController;
use App\Http\Controllers\BursaryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// ! Frontend Routes

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/purchase-admission-form', [HomeController::class, 'purchase'])->name('form.purchase');
Route::get('/school-fees-payment', [PaymentController::class, 'showfees'])->name('fees.pay');
Route::post('/school-fees-payment', [PaymentController::class, 'payfees'])->name('pay.fees');
Route::get('/school-fees-verification/{phone?}', [PaymentController::class, 'verifyFees'])->name('fees.verify');
Route::post('/school-fees-verification', [PaymentController::class, 'verify'])->name('verify');
Route::post('/student-admissions', [AdmissionController::class, 'store'])->name('admission.store');

Route::get('/storages',function(){
    Artisan::call('storage:link');
    dd('success');
});


// ! Backend Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('backend.index');
    })->name('admin.index');

    // ! Students
    Route::resource('student', StudentController::class);
    Route::get('student/promote/{id}', [StudentController::class, 'ShowPromotionForm'])->name('student.showPromotion');
    Route::post('student/promote/{id}', [StudentController::class, 'promote'])->name('student.promote');
    Route::get('student/admit/{id}', [AdmissionManagementController::class, 'admit'])->name('student.admit');

    // ! Subjects
    Route::resource('subject', SubjectController::class);

    // ! Levels
    Route::resource('level', LevelController::class);

    // ! Fees
    Route::resource('fees', FeesController::class);

    // ! Classes
    Route::resource('class', ClassController::class);
    Route::get('/assignSubject', [ClassController::class, 'assignSubjectCreate'])->name('class.subject');
    Route::post('/assignSubject', [ClassController::class, 'assignSubject'])->name('subject.assign');
    Route::get('/print-class-student-date/{id}', [ClassController::class, 'printClassData'])->name('class.students');

    // ! Users
    Route::resource('user', UserController::class);

    // ! Admissions
    Route::resource('admission', AdmissionManagementController::class);
    Route::get('offer-admission/{student}', [AdmissionManagementController::class,'admit'])->name('admission.offer');

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

    // ! Bursary
    Route::resource('bursary', BursaryController::class);

    // ! Terms
    Route::resource('term', TermController::class);
    Route::get('/termtypes', [TermController::class, 'createTermType'])->name('termtype.create');
    Route::post('/termtypes', [TermController::class, 'storeTermType'])->name('termtype.store');
});



require __DIR__.'/auth.php';
