<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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

        return view('page-employee.employee-detail', compact('title', 'employee'));
    }

    public function employeeForm()
    {
        $title = 'Form Employee - HRIS';
        return view('page-employee.employee-form', compact('title'));
    }
}
