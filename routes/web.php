<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Backend\Fees\FeesComponent;
use App\Http\Livewire\Backend\Role\RoleComponent;
use App\Http\Livewire\Backend\User\UserComponent;
use App\Http\Livewire\Backend\Level\LevelComponent;
use App\Http\Livewire\Backend\Profile\ProfileComponent;
use App\Http\Livewire\Backend\Student\StudentComponent;
use App\Http\Livewire\Backend\Classroom\ClassroomComponent;
use App\Http\Livewire\Backend\Permission\PermissionComponent;


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
    Route::get('students/{user}', StudentComponent::class)->name('backend.students');
    Route::get('student/promote/{id}', [StudentController::class, 'ShowPromotionForm'])->name('student.showPromotion');
    Route::post('student/promote/{id}', [StudentController::class, 'promote'])->name('student.promote');
    Route::get('student/admit/{id}', [AdmissionManagementController::class, 'admit'])->name('student.admit');

    // ! Subjects
    Route::resource('subject', SubjectController::class);

    // ! Levels
    Route::get('levels', LevelComponent::class)->name('backend.levels');

    // ! Fees
    Route::get('fees', FeesComponent::class)->name('backend.fees');

    // ! Classes
    Route::get('classrooms', ClassroomComponent::class)->name('backend.classrooms');
    Route::get('/assignSubject', [ClassController::class, 'assignSubjectCreate'])->name('class.subject');
    Route::post('/assignSubject', [ClassController::class, 'assignSubject'])->name('subject.assign');
    Route::get('/print-class-student-date/{id}', [ClassController::class, 'printClassData'])->name('class.students');

    // ! Users
    Route::get('users', UserComponent::class)->name('backend.users')->middleware(['role:developer|super admin']);

    // ! Profiles
    Route::get('profile/{user}', ProfileComponent::class)->name('backend.profile');

    // ! Admissions
    Route::resource('admission', AdmissionManagementController::class);
    Route::get('offer-admission/{student}', [AdmissionManagementController::class,'admit'])->name('admission.offer');

    // ! Permissions
    Route::get('permissions', PermissionComponent::class)->name('backend.permissions');

    // ! Roles
    Route::get('roles', RoleComponent::class)->name('backend.roles');

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
