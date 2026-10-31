<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\FeeController;

/*
|--------------------------------------------------------------------------
| Web Routes - Student Management System
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Students
Route::resource('students', StudentController::class);
Route::get('students/{id}/id-card', [StudentController::class, 'idCard'])->name('students.id_card');
Route::post('students/{id}/enroll', [StudentController::class, 'enrollCourse'])->name('students.enroll');

// Courses
Route::resource('courses', CourseController::class);

// Attendance
Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');

// Grades & Exam Records
Route::get('grades', [GradeController::class, 'index'])->name('grades.index');
Route::post('grades', [GradeController::class, 'store'])->name('grades.store');
Route::delete('grades/{id}', [GradeController::class, 'destroy'])->name('grades.destroy');

// Fees & Billing
Route::get('fees', [FeeController::class, 'index'])->name('fees.index');
Route::post('fees', [FeeController::class, 'store'])->name('fees.store');
Route::post('fees/{id}/pay', [FeeController::class, 'recordPayment'])->name('fees.pay');
Route::get('fees/{id}/receipt', [FeeController::class, 'receipt'])->name('fees.receipt');
