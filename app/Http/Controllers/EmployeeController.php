<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function employees()
    {
        // Data dummy untuk employees
        $employees = [
            ['id' => 1, 'name' => 'John Doe', 'position' => 'Software Engineer', 'department' => 'IT', 'status' => 'Active'],
            ['id' => 2, 'name' => 'Jane Smith', 'position' => 'HR Manager', 'department' => 'HR', 'status' => 'Active'],
            ['id' => 3, 'name' => 'Bob Johnson', 'position' => 'Marketing Specialist', 'department' => 'Marketing', 'status' => 'On Leave'],
            ['id' => 4, 'name' => 'Alice Williams', 'position' => 'Designer', 'department' => 'Design', 'status' => 'Active'],
        ];

        
        return view('page-employee.employees', compact('employees'));
    }

    public function employeeDetail()
    {
        return view('page-employee.employee-detail');
    }

    public function employeeForm()
    {
        return view('page-employee.employee-form');
    }
}
