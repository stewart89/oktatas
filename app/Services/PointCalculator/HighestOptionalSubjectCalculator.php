<?php

namespace App\Services\PointCalculator;

use App\Models\Department;
use App\Services\PointCalculator\BasePointCalculator;
use App\Services\PointCalculator\PointCalculatorInterface;
use Exception;

class HighestOptionalSubjectCalculator extends BasePointCalculator implements PointCalculatorInterface{

    public function __construct(Department $department)
    {
        parent::__construct($department);
    }

    public function calculate(array $resultList): int{

        $optionalSubjects = $this->department->optionalSubjects()->get();

        if($optionalSubjects->isEmpty()){
            throw new Exception('The department does not have any optional subjects');
        }

        $maxPoint = 0;
        foreach ($resultList as $result) {
            foreach ($optionalSubjects as $requiredSubject) {
                if ($this->isSubjectMatch($result, $requiredSubject)) {
                    
                    $maxPoint = $this->getHighestPoints($maxPoint, $result);
                }
            }
        }

        return $this->doublePoints($maxPoint);
    }

    private function getHighestPoints($maxPoint, $result){

        return max([$maxPoint, $this->convertIntoInt($result['eredmeny'])]);
    }
}