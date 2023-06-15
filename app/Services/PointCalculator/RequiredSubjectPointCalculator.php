<?php

namespace App\Services\PointCalculator;

use Exception;
use App\Models\Department;
use App\Services\PointCalculator\BasePointCalculator;
use App\Services\PointCalculator\PointCalculatorInterface;

class RequiredSubjectPointCalculator extends BasePointCalculator implements PointCalculatorInterface{

    public function __construct(Department $department)
    {
        parent::__construct($department);
    }
    
    /**
     * calculate
     *
     * @param  array $resultList
     * @return int
     */
    public function calculate(array $resultList): int{

        $requiredSubjects = $this->department->requiredSubjects()->get();

        if($requiredSubjects->isEmpty()){
            throw new Exception('The department does not have any optional subjects');
        }

        foreach ($resultList as $result) {
            foreach ($requiredSubjects as $requiredSubject) {
                if ($this->isSubjectMatch($result, $requiredSubject)) {
                    return $this->doublePoints($this->convertIntoInt($result['eredmeny']));
                }
            }
        }
    }
}