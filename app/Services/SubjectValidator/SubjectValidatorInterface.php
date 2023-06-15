<?php

namespace App\Services\SubjectValidator;

use App\Models\Department;

interface SubjectValidatorInterface
{
    public function validate(Department $department, array $resultLists): void;
}