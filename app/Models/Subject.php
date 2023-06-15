<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_subject')
            ->withPivot('type')
            ->withPivot('level')
            ->withTimestamps();
    }
}
