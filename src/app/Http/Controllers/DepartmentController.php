<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->orderBy('name')->paginate(10);

        return view('departments.index', compact('departments'));
    }

public function create()
{
    $this->authorize('create', Department::class);
    return view('departments.create');
}

public function store(StoreDepartmentRequest $request)
{
    $this->authorize('create', Department::class);

    Department::create($request->validated());
    return redirect()->route('departments.index')->with('success', '部署を作成しました');
}

public function edit(Department $department)
{
    $this->authorize('update', $department);
    return view('departments.edit', compact('department'));
}

public function update(UpdateDepartmentRequest $request, Department $department)
{
    $this->authorize('update', $department);

    $department->update($request->validated());
    return redirect()->route('departments.index')->with('success', '部署を更新しました');
}

public function destroy(Department $department)
{
    $this->authorize('delete', $department);

    if ($department->employees()->exists()) {
        return back()->with('error', '社員が所属している部署は削除できません');
    }

    $department->delete();
    return redirect()->route('departments.index')->with('success', '部署を削除しました');
}
    }