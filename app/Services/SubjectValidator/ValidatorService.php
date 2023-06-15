<?php

namespace App\Services\SubjectValidator;

use App\Models\Department;
use App\Services\SubjectValidator\SubjectValidatorInterface;

class ValidatorService
{

    protected $validator;

    public function __construct(SubjectValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function setValidator($validator) {
        $this->validator = $validator;
    }

    public function validate(Department $department, array $resultList): void
    {
        $this->validator->validate($department, $resultList);
    }
}
