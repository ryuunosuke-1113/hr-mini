<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')->id;

        return [
            'department_id' => ['required','exists:departments,id'],
            'name'          => ['required','max:255'],
            'email'         => ['required','email','max:255','unique:employees,email,' . $employeeId],
            'joined_on'     => ['required','date'],
        ];
    }
}