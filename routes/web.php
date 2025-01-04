<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PerformanceReportController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [EmployeeController::class, 'dashboard'])
    ->middleware(['auth', 'verified']) // Apply auth and verified middleware
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index'); 
Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create'); 
Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit'); 
Route::put('/employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update'); 
Route::get('/employee/show/{id}', [EmployeeController::class, 'show'])->name('employee.show'); 
Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');  

Route::get('/qrcode', [QRCodeController::class, 'generate'])->name('qrcode.index');
Route::get('/qrcode/regenerate', [QRCodeController::class, 'regenerate'])->name('qrcode.regenerate');




Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/update', [AttendanceController::class, 'update'])->name('attendance.update');
Route::get('attendance/download/excel', [AttendanceController::class, 'downloadExcel'])->name('attendance.download.excel');
Route::get('attendance/download/pdf', [AttendanceController::class, 'downloadPDF'])->name('attendance.download.pdf');

Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
Route::put('/leave/{id}', [LeaveController::class, 'updateStatus'])->name('leave.updateStatus');

Route::resource('admin', AdminController::class);

Route::get('performance-report', [PerformanceReportController::class, 'index'])->name('performance_report.index');
Route::post('performance-report', [PerformanceReportController::class, 'generateReport'])->name('performance_report.generate');
Route::post('performance-report/download-pdf', [PerformanceReportController::class, 'downloadPDF'])->name('performance_report.download_pdf');
