<?php

namespace App\Services\PointCalculator;

use App\Models\Department;
use App\Services\PointCalculator\PointCalculatorInterface;

abstract class BasePointCalculator{

    protected $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }
    
    /**
     * isSubjectMatch
     *
     * @param  array $subject
     * @param  Subject $requiredSubject
     * @return bool
     */
    protected function isSubjectMatch(array $subject, $requiredSubject): bool
    {

        if(isset($requiredSubject->pivot->level)){
            return strtolower($subject['nev']) === strtolower($requiredSubject->name) && strtolower($subject['tipus']) === strtolower($requiredSubject->pivot->level);
        }
        
        return strtolower($subject['nev']) === strtolower($requiredSubject->name);
    }
    
    /**
     * Double the incoming points
     *
     * @param  int $point
     * @return int
     */
    protected function doublePoints(int $point): int{

        return $point * 2;
    }
    
    /**
     * Converts into int
     *
     * @param  mixed $point
     * @return int
     */
    protected function convertIntoInt(mixed $point): int{

        return intval($point);
    }
}