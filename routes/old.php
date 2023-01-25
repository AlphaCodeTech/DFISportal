<?php

use App\Http\Controllers\ClassController;

Route::get('student/promote/{id}', [StudentController::class, 'ShowPromotionForm'])->name('student.showPromotion');
Route::post('student/promote/{id}', [StudentController::class, 'promote'])->name('student.promote');

Route::get('/assignSubject', [ClassController::class, 'assignSubjectCreate'])->name('class.subject');
Route::post('/assignSubject', [ClassController::class, 'assignSubject'])->name('subject.assign');
Route::get('/print-class-student-date/{id}', [ClassController::class, 'printClassData'])->name('class.students');
Route::get('/termtypes', [TermController::class, 'createTermType'])->name('termtype.create');
Route::post('/termtypes', [TermController::class, 'storeTermType'])->name('termtype.store');