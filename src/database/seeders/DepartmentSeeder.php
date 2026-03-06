<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
public function run(): void
{
    Department::create(['name' => '総務']);
    Department::create(['name' => '経理']);
    Department::create(['name' => '人事']);
}}
