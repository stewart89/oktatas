<?php

namespace Tests\Unit;

use App\Models\Department;
use PHPUnit\Framework\TestCase;
use App\Services\PointCalculator\BasePointCalculator;

class BasePointCalculatorTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_is_subject_match()
    {

        $department = new Department();
        $calculator = new TestPointCalculator($department);
        
        $subject1 = ['nev' => 'Matek', 'tipus' => 'emelt'];
        $subject2 = ['nev' => 'Francia'];

        $requiredSubject1 = (object)['name' => 'Matek', 'pivot_level' => 'emelt'];
        $requiredSubject2 = (object)['name' => 'Francia'];

        $this->assertTrue($calculator->isSubjectMatch($subject1, $requiredSubject1));
        $this->assertFalse($calculator->isSubjectMatch($subject2, $requiredSubject1));

        $this->assertFalse($calculator->isSubjectMatch($subject1, $requiredSubject2));
        $this->assertTrue($calculator->isSubjectMatch($subject2, $requiredSubject2));

    }

    public function test_double_points()
    {
        $department = new Department();
        $calculator = new TestPointCalculator($department);

        $point1 = 5;
        $point2 = 10;
        $point3 = 0;

        $this->assertEquals(10, $calculator->doublePoints($point1));
        $this->assertEquals(20, $calculator->doublePoints($point2));
        $this->assertEquals(0, $calculator->doublePoints($point3));
    }

    public function test_convert_into_int()
    {
        $department = new Department();
        $calculator = new TestPointCalculator($department);

        $point1 = '5';
        $point2 = '2.5';
        $point3 = '66%';

        $this->assertEquals(5, $calculator->convertIntoInt($point1));
        $this->assertEquals(2, $calculator->convertIntoInt($point2));
        $this->assertEquals(66, $calculator->convertIntoInt($point3));
    }
}

class TestPointCalculator extends BasePointCalculator
{
    public function isSubjectMatch(array $subject, $requiredSubject): bool
    {
        return parent::isSubjectMatch($subject, $requiredSubject);
    }

    public function doublePoints(int $point): int
    {
        return parent::doublePoints($point);
    }

    public function convertIntoInt(mixed $point): int
    {
        return parent::convertIntoInt($point);
    }
}
