<?php

namespace App\Services\SubjectValidator;

use App\Models\Department;
use App\Services\SubjectValidator\SubjectValidatorInterface;


class ExtraSubjectValidator implements SubjectValidatorInterface{


    public function validate(Department $department, array $resultList): void
    {
        
    }
}