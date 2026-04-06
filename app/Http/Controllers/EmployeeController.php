<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use App\Models\EmployeeBank;
use App\Models\EmployeeEmergency;
use App\Models\EmployeeIndentities;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function employees()
    {
        $title = 'All Employees - HRIS';
        $employees = Employee::all();

        return view('page-employee.employees', compact('employees', 'title'));
    }

    public function employeeDetail($id)
    {
        $title = 'Employee Detail - HRIS';
        $employee = Employee::findOrFail($id);
        // dd($employee->identity->nik_ktp);

        return view('page-employee.employee-detail', compact('title', 'employee'));
    }

    public function employeeEdit($id)
    {
        $title = 'Employee Edit - HRIS';
        $employee = Employee::findOrFail($id);
        $divisions = Division::all();
        // dd($employee->identity->nik_ktp);

        return view('page-employee.employee-form-update', compact('title', 'employee'));
    }

    public function employeeForm()
    {
        $title = 'Form Employee - HRIS';
        return view('page-employee.employee-form', compact('title'));
    }
}
