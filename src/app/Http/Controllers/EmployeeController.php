<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;

class EmployeeController extends Controller
{
public function index()
{
    $q = request('q');
    $departmentId = request('department_id');
    $sort = request('sort', 'id');
    $direction = request('direction', 'desc');

    $allowedSorts = ['id', 'name', 'joined_on', 'department_id'];

    if (!in_array($sort, $allowedSorts)) {
        $sort = 'id';
    }

    if (!in_array($direction, ['asc', 'desc'])) {
        $direction = 'desc';
    }

    $employees = Employee::with('department')
        ->when($q, function ($query) use ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        })
        ->when($departmentId, function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })
        ->orderBy($sort, $direction)
        ->paginate(10)
        ->appends(request()->query());

    $departments = Department::orderBy('name')->get();

    return view('employees.index', compact(
        'employees', 'departments', 'q', 'departmentId', 'sort', 'direction'
    ));
}    

public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('employees.create', compact('departments'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        Employee::create($request->validated());

        return redirect()->route('employees.index')
            ->with('success', '社員を追加しました');
    }

    public function edit(Employee $employee)
    {
        $departments = Department::orderBy('name')->get();
        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return redirect()->route('employees.index')
            ->with('success', '社員情報を更新しました');
    }

public function destroy(Employee $employee)
{
    $this->authorize('delete', $employee);

    $employee->delete();

    return redirect()
        ->route('employees.index')
        ->with('success', '削除しました');
}
    }