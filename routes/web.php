<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BursaryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\BackendIndexController;
use App\Http\Livewire\Backend\Exam\ExamComponent;
use App\Http\Livewire\Backend\Fees\FeesComponent;
use App\Http\Livewire\Backend\Role\RoleComponent;
use App\Http\Livewire\Backend\Term\TermComponent;
use App\Http\Livewire\Backend\User\UserComponent;
use App\Http\Livewire\Backend\Student\StudentList;
use App\Http\Livewire\Backend\Event\EventComponent;
use App\Http\Livewire\Backend\Grade\GradeComponent;
use App\Http\Livewire\Backend\Level\LevelComponent;
use App\Http\Livewire\Backend\Exam\ExamMarkComponent;
use App\Http\Livewire\Backend\Student\PromotionManage;
use App\Http\Controllers\AdmissionManagementController;
use App\Http\Controllers\Backend\Mark\MarkController;
use App\Http\Livewire\Backend\Exam\ExamManageComponent;
use App\Http\Livewire\Backend\Profile\ProfileComponent;
use App\Http\Livewire\Backend\Session\SessionComponent;
use App\Http\Livewire\Backend\Settings\SystemComponent;
use App\Http\Livewire\Backend\Student\StudentComponent;
use App\Http\Livewire\Backend\Student\StudentGraduated;
use App\Http\Livewire\Backend\Student\StudentPromotion;
use App\Http\Livewire\Backend\Subject\SubjectComponent;
use App\Http\Livewire\Backend\Classroom\ClassroomSection;
use App\Http\Livewire\Backend\Guardian\GuardianComponent;
use App\Http\Livewire\Backend\Settings\AcademicComponent;
use App\Http\Livewire\Backend\Classroom\ClassroomComponent;
use App\Http\Livewire\Backend\Department\DepartmentComponent;
use App\Http\Livewire\Backend\Permission\PermissionComponent;
use App\Http\Livewire\Backend\Subject\AssignSubjectToTeacher;
use App\Http\Livewire\Backend\Classroom\ClassesAssignedSubjects;
use App\Http\Livewire\Backend\Exam\BatchFix;
use App\Http\Livewire\Backend\Exam\ExamMarkBulk;
use App\Http\Livewire\Backend\Exam\TabulationSheet;
use App\Http\Livewire\Backend\Pin\PinComponent;
use App\Http\Livewire\Backend\Pin\PinEnter;
use App\Http\Livewire\Backend\Settings\AdmissionComponent;
use App\Http\Livewire\Backend\Settings\TeamComponent;

// ! Frontend Routes

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('/continue-registration', [HomeController::class, 'continue'])->name('form.continue');
Route::get('/guardian-create', [HomeController::class, 'guardianCreate'])->name('guardian.create');
Route::post('/guardian-store', [HomeController::class, 'guardianStore'])->name('guardian.store');
Route::get('/purchase-admission-form/{guardian}', [HomeController::class, 'purchase'])->name('form.purchase');
Route::get('/school-fees-payment', [PaymentController::class, 'schoolFeeCreate'])->name('fees.show');
Route::post('/school-fees-payment', [PaymentController::class, 'schoolFeeStore'])->name('fees.store');
Route::get('/school-fees-verification/{phone?}', [PaymentController::class, 'verifyFees'])->name('fees.verify');
Route::post('/school-fees-verification', [PaymentController::class, 'verify'])->name('verify');
Route::post('/student-admissions', [AdmissionController::class, 'store'])->name('admission.store');
Route::get('/admission-form-payment/{guardian}', [PaymentController::class, 'formFeeCreate'])->name('form.fee.create');
Route::post('/admission-form-payment', [PaymentController::class, 'formFeeStore'])->name('form.fee.store');


Route::get('/storages', function () {
    Artisan::call('storage:link');
    dd('success');

});

// ! Backend Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [BackendIndexController::class, 'index'])->name('backend.index');
    Route::post('/update-event', [BackendIndexController::class, 'calendarEvents'])->name('event.update')->middleware('permission:create event');

    // ! Students
    Route::group(['prefix' => 'students'], function () {
        Route::get('/{user}', StudentComponent::class)->name('backend.students');
        Route::get('/list/{class}', StudentList::class)->name('students.list');
        Route::get('/promotion-manage', PromotionManage::class)->name('students.promotion_manage');
        Route::get('/students-graduated', StudentGraduated::class)->name('students.graduated');
        Route::get('/promotion/{currentClass?}/{currentSection?}/{nextClass?}/{nextSection?}', StudentPromotion::class)->name('students.promotion');
    });

    Route::get('student/admit/{id}', [AdmissionManagementController::class, 'admit'])->name('student.admit');

    // ! Subjects
    Route::group(['prefix' => 'subjects'], function () {
        Route::get('/', SubjectComponent::class)->name('backend.subjects');
        Route::get('/assign-subjects-to-teachers', AssignSubjectToTeacher::class)->name('teacher.assign');
    });

    // ! Levels
    Route::group(['prefix' => 'levels'], function () {
        Route::get('/', LevelComponent::class)->name('backend.levels');
    });

    // ! Fees
    Route::group(['prefix' => 'payments'], function () {
        Route::get('/', FeesComponent::class)->name('backend.fees');
    });

    // ! Classes
    Route::group(['prefix' => 'classrooms'], function () {
        Route::get('/', ClassroomComponent::class)->name('backend.classrooms');
        Route::get('class-sections/{classSection}', ClassroomSection::class)->name('class.sections');
        Route::get('class-assigned-subjects', ClassesAssignedSubjects::class)->name('classes.assigned');
    });

    // ! Users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', UserComponent::class)->name('backend.users')->middleware(['role:developer|super admin|teacher']);
    });

    // ! Profiles
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/{user}', ProfileComponent::class)->name('backend.profile');
    });

    // ! Events
    Route::group(['prefix' => 'events'], function () {
        Route::get('/', EventComponent::class)->name('backend.events');
    });

    // ! Admissions
    Route::group(['prefix' => 'admission'], function () {
        Route::get('/', [AdmissionManagementController::class, 'index'])->name('admission.index');
        Route::get('offer-admission/{student}', [AdmissionManagementController::class, 'admit'])->name('admission.offer');
    });

    // ! Permissions
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', PermissionComponent::class)->name('backend.permissions')->middleware(['role:developer|super admin']);
    });

    // ! Roles
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', RoleComponent::class)->name('backend.roles');
    });

    // ! Departments
    Route::group(['prefix' => 'departments'], function () {
        Route::get('/', DepartmentComponent::class)->name('backend.departments');
    });

    // ! Academic Sessions
    Route::group(['prefix' => 'sessions'], function () {
        Route::get('/', SessionComponent::class)->name('backend.sessions');
    });

    // ! Parents
    Route::group(['prefix' => 'parents'], function () {
        Route::get('/', GuardianComponent::class)->name('backend.parents');
    });

    // ! Payment
    Route::group(['prefix' => 'bursary'], function () {
        Route::resource('/', BursaryController::class);
    });

    // ! Terms
    Route::group(['prefix' => 'terms'], function () {
        Route::get('/', TermComponent::class)->name('backend.terms');
    });

    // ! Exams
    Route::group(['prefix' => 'exams'], function () {
        Route::get('/', ExamComponent::class)->name('backend.exams');
    });

    // ! Grades
    Route::group(['prefix' => 'grades'], function () {
        Route::get('/', GradeComponent::class)->name('backend.grades');
    });

    // ! Marks
    Route::group(['prefix' => 'marks'], function () {
        // FOR teamSAT
        Route::group(['middleware' => 'teamSAT'], function () {
            Route::get('/', ExamMarkComponent::class)->name('backend.marks');
            Route::get('bulk/{class?}/{section?}', ExamMarkBulk::class)->name('marks.bulk');
            Route::get('management/{exam_id}/{class_id}/{section_id}/{subject_id}', ExamManageComponent::class)->name('marks.manage');
            Route::get('select_year/{id}', [MarkController::class, 'year_selector'])->name('marks.year_selector');
            Route::post('select_year/{id}', [MarkController::class, 'year_selected'])->name('marks.year_select');
            Route::get('show/{id}/{year}', [MarkController::class, 'show'])->name('marks.show');
            Route::get('print/{id}/{exam_id}/{year}', [MarkController::class, 'print_view'])->name('marks.print');
            Route::put('comment_update/{exam_record_id}', [MarkController::class, 'comment_update'])->name('marks.comment_update');
            Route::put('skills_update/{skill}/{exam_record_id}', [MarkController::class, 'skills_update'])->name('marks.skills_update');
        });

        // FOR teamSA
        Route::group(['middleware' => 'teamSA'], function () {
            Route::get('batch_fix', BatchFix::class)->name('marks.batch_fix');
            Route::get('tabulation/{exam_id?}/{class_id?}/{section_id?}', TabulationSheet::class)->name('marks.tabulation');
            Route::post('tabulation', [MarkController::class, 'tabulation_select'])->name('marks.tabulation_select');
            Route::get('tabulation/print/{exam}/{class}/{sec_id}', [MarkController::class, 'print_tabulation'])->name('marks.print_tabulation');
        });
    });

    /*************** Pins *****************/
    Route::group(['prefix' => 'pins'], function () {
        Route::get('/', PinComponent::class)->name('backend.pins');
        Route::get('enter/{id}', PinEnter::class)->name('pins.enter');
        Route::post('verify/{id}', [PinController::class, 'verify'])->name('pins.verify');
    });
});

Route::prefix('settings')->middleware(['auth', 'role:super admin|developer'])->group(function () {
    Route::get('system', SystemComponent::class)->name('setting.system');
    Route::get('academic', AcademicComponent::class)->name('setting.academic');
    Route::get('team', TeamComponent::class)->name('setting.team');
    Route::get('admission', AdmissionComponent::class)->name('setting.admission');
});


require __DIR__ . '/auth.php';
