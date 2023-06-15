<?php

namespace App\Services\PointCalculator;

use App\Models\Department;
use App\Services\PointCalculator\PointCalculatorInterface;
use App\Services\PointCalculator\ExtraSubjectPointCalculator;
use App\Services\PointCalculator\RequiredSubjectPointCalculator;
use App\Services\PointCalculator\HighestOptionalSubjectCalculator;

class PointCalculatorFactory
{
    private $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    public function createRequiredSubjectCalculator(): PointCalculatorInterface
    {
        return new RequiredSubjectPointCalculator($this->department);
    }

    public function createHighestOptionalSubjectCalculator(): PointCalculatorInterface
    {
        return new HighestOptionalSubjectCalculator($this->department);
    }

    public function createExtraSubjectPointCalculator(): PointCalculatorInterface
    {
        return new ExtraSubjectPointCalculator($this->department);
    }
}