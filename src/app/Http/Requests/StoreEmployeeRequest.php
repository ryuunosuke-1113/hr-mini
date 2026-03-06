<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required','exists:departments,id'],
            'name'          => ['required','max:255'],
            'email'         => ['required','email','max:255','unique:employees,email'],
            'joined_on'     => ['required','date'],
        ];
    }
}