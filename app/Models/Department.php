<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'department_subject')
            ->withPivot('type')
            ->withPivot('level')
            ->withTimestamps();
    }

    public function requiredSubjects()
    {
        return $this->belongsToMany(Subject::class)->withPivot('level')->where('type', 'required');
    }

    public function optionalSubjects()
    {
        return $this->belongsToMany(Subject::class)->withPivot('level')->where('type', 'optional');
    }
}
