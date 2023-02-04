<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BursaryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\BackendIndexController;
use App\Http\Livewire\Backend\Fees\FeesComponent;
use App\Http\Livewire\Backend\Role\RoleComponent;
use App\Http\Livewire\Backend\Term\TermComponent;
use App\Http\Livewire\Backend\User\UserComponent;
use App\Http\Livewire\Backend\Student\StudentList;
use App\Http\Livewire\Backend\Event\EventComponent;
use App\Http\Livewire\Backend\Level\LevelComponent;
use App\Http\Livewire\Backend\Student\PromotionManage;
use App\Http\Controllers\AdmissionManagementController;
use App\Http\Livewire\Backend\Profile\ProfileComponent;
use App\Http\Livewire\Backend\Session\SessionComponent;
use App\Http\Livewire\Backend\Settings\SystemComponent;
use App\Http\Livewire\Backend\Student\StudentComponent;
use App\Http\Livewire\Backend\Student\StudentPromotion;
use App\Http\Livewire\Backend\Subject\SubjectComponent;
use App\Http\Livewire\Backend\Classroom\ClassroomSection;
use App\Http\Livewire\Backend\Guardian\GuardianComponent;
use App\Http\Livewire\Backend\Settings\AcademicComponent;
use App\Http\Livewire\Backend\Classroom\ClassroomComponent;
use App\Http\Livewire\Backend\Department\DepartmentComponent;
use App\Http\Livewire\Backend\Permission\PermissionComponent;
use App\Http\Livewire\Backend\Student\StudentGraduated;

// ! Frontend Routes

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/purchase-admission-form', [HomeController::class, 'purchase'])->name('form.purchase');
Route::get('/school-fees-payment', [PaymentController::class, 'showfees'])->name('fees.pay');
Route::post('/school-fees-payment', [PaymentController::class, 'payfees'])->name('pay.fees');
Route::get('/school-fees-verification/{phone?}', [PaymentController::class, 'verifyFees'])->name('fees.verify');
Route::post('/school-fees-verification', [PaymentController::class, 'verify'])->name('verify');
Route::post('/student-admissions', [AdmissionController::class, 'store'])->name('admission.store');

Route::get('/storages', function () {
    Artisan::call('storage:link');
    dd('success');
});


// ! Backend Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [BackendIndexController::class, 'index'])->name('backend.index');
    Route::post('/update-event', [BackendIndexController::class, 'calendarEvents'])->name('event.update')->middleware('permission:create event');

    // ! Students
    Route::get('students/{user}', StudentComponent::class)->name('backend.students');
    Route::get('students/list/{class}', StudentList::class)->name('students.list');
    Route::get('students-promotion/manage', PromotionManage::class)->name('students.promotion_manage');
    Route::get('students-graduated', StudentGraduated::class)->name('students.graduated');
    Route::get('student-promotion/{currentClass?}/{currentSection?}/{nextClass?}/{nextSection?}', StudentPromotion::class)->name('students.promotion');

    Route::get('student/admit/{id}', [AdmissionManagementController::class, 'admit'])->name('student.admit');

    // ! Subjects
    Route::get('subjects', SubjectComponent::class)->name('backend.subjects');

    // ! Levels
    Route::get('levels', LevelComponent::class)->name('backend.levels');

    // ! Fees
    Route::get('fees', FeesComponent::class)->name('backend.fees');

    // ! Classes
    Route::get('classrooms', ClassroomComponent::class)->name('backend.classrooms');
    Route::get('class-sections/{classSection}', ClassroomSection::class)->name('class.sections');

    // ! Users
    Route::get('users', UserComponent::class)->name('backend.users')->middleware(['role:developer|super admin|teacher']);

    // ! Profiles
    Route::get('profile/{user}', ProfileComponent::class)->name('backend.profile');

    // ! Events
    Route::get('events', EventComponent::class)->name('backend.events');

    // ! Admissions
    Route::resource('admission', AdmissionManagementController::class);
    Route::get('offer-admission/{student}', [AdmissionManagementController::class, 'admit'])->name('admission.offer');

    // ! Permissions
    Route::get('permissions', PermissionComponent::class)->name('backend.permissions')->middleware(['role:developer|super admin']);

    // ! Roles
    Route::get('roles', RoleComponent::class)->name('backend.roles');

    // ! Departments
    Route::get('departments', DepartmentComponent::class)->name('backend.departments');

    // ! Academic Sessions
    Route::get('sessions', SessionComponent::class)->name('backend.sessions');

    // ! Parents
    Route::get('parents', GuardianComponent::class)->name('backend.parents');

    // ! Bursary
    Route::resource('bursary', BursaryController::class);

    // ! Terms
    Route::get('terms', TermComponent::class)->name('backend.terms');
});

Route::prefix('settings')->middleware(['auth'])->group(function () {
    Route::get('system', SystemComponent::class)->name('setting.system');
    Route::get('academic', AcademicComponent::class)->name('setting.academic');
});


//! Continue on settings and then student promotion features
require __DIR__ . '/auth.php';
