<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'department_id',
        'name',
        'email',
        'joined_on',
    ];

    protected $casts = [
        'joined_on' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}