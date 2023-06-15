<?php

namespace Tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use App\Services\SubjectValidator\BasicSubjectValidator;

class BasicSubjectValidatorTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_check_does_not_reach_minimum_points()
    {

        $validator = new BasicSubjectValidator();
        $resultList = [
            ['nev' => 'matek', 'eredmeny' => '80%'],
            ['nev' => 'angol', 'eredmeny' => '15%'],
        ];
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('A következő tárgy: angol nem érte el a 20 pontos határt');
        $validator->checkMinimumPoints($resultList);
    }
}
