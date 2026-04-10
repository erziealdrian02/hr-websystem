<?php

use App\Http\Controllers\AdminAttendanceController;
use App\Http\Controllers\AdminLeaveController;
use App\Http\Controllers\AdminOvertimeController;
use App\Http\Controllers\AdminPayrollController;
use App\Http\Controllers\AdminReimburseController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\ReimburseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    // Rute Employee Management
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/employees', [EmployeeController::class, 'employees'])->name('employees.index');
    Route::get('/employees/detail/{id}', [EmployeeController::class, 'employeeDetail'])->name('employees.detail');
    Route::get('/employees/form', [EmployeeController::class, 'employeeForm'])->name('employees.form');
    Route::post('/employees/store', [EmployeeController::class, 'employeeStore'])->name('employees.store');
    Route::get('/employees/edit/{id}', [EmployeeController::class, 'employeeEdit'])->name('employees.edit');
    Route::put('/employees/update/{id}', [EmployeeController::class, 'employeeUpdate'])->name('employees.update');
    Route::delete('/employees/delete/{id}', [EmployeeController::class, 'employeeDestroy'])->name('employees.destroy');

    Route::get('/placement', [PlacementController::class, 'placement'])->name('placement.index');
    Route::get('/placement/form', [PlacementController::class, 'placementForm'])->name('placement.form');
    Route::post('/placement/store', [PlacementController::class, 'store'])->name('placement.store');
    Route::put('/placement/update/{placement}', [PlacementController::class, 'update'])->name('placement.update');
    Route::delete('/placement/delete/{placement}', [PlacementController::class, 'destroy'])->name('placement.destroy');

    Route::resource('client-locations', \App\Http\Controllers\ClientLocationController::class);

    Route::get('/division', [DivisionController::class, 'division'])->name('division.index');
    Route::get('/division/form', [DivisionController::class, 'divisionForm'])->name('division.form');
    Route::post('/division/store', [DivisionController::class, 'store'])->name('division.store');
    Route::get('/division/edit/{id}', [DivisionController::class, 'edit'])->name('division.edit');
    Route::put('/division/update/{id}', [DivisionController::class, 'update'])->name('division.update');
    Route::delete('/division/delete/{id}', [DivisionController::class, 'destroy'])->name('division.destroy');
    Route::get('/division/generate-code', [DivisionController::class, 'generateCode'])->name('division.generate-code');

    Route::get('/contract', [ContractController::class, 'contract'])->name('contract.index');
    Route::post('/contract/store', [ContractController::class, 'store'])->name('contract.store');
    Route::put('/contract/update/{id}', [ContractController::class, 'update'])->name('contract.update');
    Route::delete('/contract/delete/{id}', [ContractController::class, 'destroy'])->name('contract.destroy');

    Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('attendance.index');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::put('/attendance/clock-out/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::post('/attendance/correction', [AttendanceController::class, 'storeCorrection'])->name('attendance.correction');

    Route::get('/leave', [LeaveController::class, 'leave'])->name('leave.index');

    Route::get('/overtime', [OvertimeController::class, 'overtime'])->name('overtime.index');

    Route::get('/payroll', [PayrollController::class, 'payroll'])->name('payroll.index');

    Route::get('/reimburse', [ReimburseController::class, 'reimburse'])->name('reimburse.index');

    Route::get('/performance', [PerformanceController::class, 'performance'])->name('performance.index');

    Route::get('/users', [UserController::class, 'users'])->name('users.index');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.index');

    // Admin Route
    Route::get('/leave-request', [AdminLeaveController::class, 'leaveAdmin'])->name('leave.index.admin');
    Route::get('/all-attendance', [AdminAttendanceController::class, 'attendanceAdmin'])->name('attendance.index.admin');
    Route::get('/overtime-request', [AdminOvertimeController::class, 'overtimeAdmin'])->name('overtime.index.admin');
    Route::get('/all-payroll', [AdminPayrollController::class, 'payrollAdmin'])->name('payroll.index.admin');
    Route::get('/reimburse-approval', [AdminReimburseController::class, 'reimburseAdmin'])->name('reimburse.index.admin');

    // Rute Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
