<?php

namespace App\Services\SubjectValidator;

use Exception;
use App\Models\Subject;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Services\SubjectValidator\SubjectValidatorInterface;

class BasicSubjectValidator implements SubjectValidatorInterface{

    private const MIN_POINT = 20;

    public function validate(Department $department, array $resultList): void
    {
        $this->checkRequiredSubjects($resultList)
            ->checkMinimumPoints($resultList)
            ->checkSubjectWichIsRequiredForASpecificDepartment($department, $resultList)
            ->checkIfThereAtLeastOneOptionalSubject($department, $resultList);
    }

   
    /**
     * Checks if the given result contains all of the required subjects
     *
     * @param  array $resultList - Contains the result of exam
     * @return BasicSubjectValidator
     */
    private function checkRequiredSubjects(array $resultList): self{

        $requiredSubjects = Subject::where('required', 1)->get([DB::raw('LOWER(name) as name')])->pluck('name')->toArray();
        $incomingResults = array_map('strtolower', array_column($resultList, 'nev'));
        $missingSubjects = array_diff($requiredSubjects, $incomingResults);
        
        if(!empty($missingSubjects)){
            throw new Exception('Hiányzó kötelező tárgyak: ' . implode(', ', $missingSubjects));
        }

        return $this;
    }
    
    /**
     * Checks if the given result reached the minimum points
     *
     * @param  array $resultList - Contains the result of exam
     * @return BasicSubjectValidator
     */
    public function checkMinimumPoints(array $resultList): self{

        foreach ($resultList as $subject) {
            if((int)$subject['eredmeny'] < self::MIN_POINT){
                throw new Exception('A következő tárgy: ' . $subject['nev'] . ' nem érte el a ' . self::MIN_POINT . ' pontos határt');
            }
        }

        return $this;
    }
    
    /**
     * Checks if there are subject wich is required for a specific department
     * Itt az IT-nál nincs külön kötelező mert az a matek az benne van az alapban, de pl ha infó kötelező lenen akkor azt vizsgálni hogy hol van meg az infó és ahol nincs nem engedné tovább
     *
     * @param  Model $department
     * @param  array $resultList
     * @return BasicSubjectValidator
     */
    private function checkSubjectWichIsRequiredForASpecificDepartment(Department $department, array $resultList): self
    {
        $requiredSubjects = $department->requiredSubjects()->get();
        if($requiredSubjects->isEmpty()){
            throw new Exception('Nincs beállitva kötelező tárgy a(z) ' . $department->name . ' osztályhoz!');
        }

        foreach ($requiredSubjects as $subject) {
            
            $found = false;
            foreach ($resultList as $value) {
                if(strtolower($subject->name) === strtolower($value['nev'])){
                    /** Ha van kötelező tárgy és van neki szint beállitva akkor muszáj hogy az legyen, tehét ha angol emelt és valakinek csak az angol közép van meg az nem megfelelő */
                    if($subject->pivot->level && strtolower($subject->pivot->level) != mb_strtolower($value['tipus'])){
                        throw new Exception('A(z) '.$subject->name.' tárgy tipúsa nem megfelelő, elvárt: ' . $subject->pivot->level);
                    }
                    $found = true;
                }
            }

            if(!$found){
                throw new Exception('Hiányzik az osztály specifikus tárgy: ' . $subject->name);
            }
        }

        return $this;
    }
    
    /**
     * Check if there is at least one optional subject in the list
     *
     * @param  Department $department
     * @param  array $resultList
     * @return BasicSubjectValidator
     */
    private function checkIfThereAtLeastOneOptionalSubject(Department $department, array $resultList): self
    {
        $optionalSubjects = $department->optionalSubjects()->get(['*', DB::raw('LOWER(name) as nev')])->pluck('nev')->toArray();
        if(empty($optionalSubjects)){
            throw new Exception('Nincs beállitva opcionális tárgy a(z) ' . $department->name . ' osztályhoz!');
        }

        $totalResultList = array_map(function($item){
            return strtolower($item['nev']);
        }, $resultList);

        
        if(empty(array_intersect($optionalSubjects, $totalResultList))){
            throw new Exception('Hiányzik legalább egy opciónális tárgy');
        };

        return $this;
    }

}

