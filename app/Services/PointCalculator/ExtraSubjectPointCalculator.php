<?php

namespace App\Services\PointCalculator;

use App\Services\PointCalculator\PointCalculatorInterface;

class ExtraSubjectPointCalculator implements PointCalculatorInterface{

    public function calculate(array $subjectList): int{

        return 0;
    }
}