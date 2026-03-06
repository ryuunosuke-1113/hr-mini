<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
public function run(): void
{
    Employee::create([
        'department_id' => 1,
        'name' => '内藤 竜飛',
        'email' => 'ryuto@example.com',
        'joined_on' => '2024-04-01',
    ]);

    Employee::create([
        'department_id' => 2,
        'name' => '山田 太郎',
        'email' => 'yamada@example.com',
        'joined_on' => '2023-01-15',
    ]);
}
}
