<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\BasicPointCalculator;
use App\Services\BasicPointsCalculator;
use App\Services\PointCalculatorService;
use App\Services\PointsCalculationService;
use App\Services\SubjectValidator\ValidatorService;
use App\Services\PointCalculator\PointCalculatorFactory;
use App\Services\SubjectValidator\BasicSubjectValidator;
use App\Services\SubjectValidator\ExtraSubjectValidator;
use Exception;
use Inertia\Inertia;

class CalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Calculate', [
            'departments' => Department::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function calculate(Request $request)
    {

        $departmentName = $request->input('szak');
        $results = json_decode($request->input('eredmenyek'), true);
        //$extraPoints = $request->input('tobbletpontok');

       /* $data = [
            'valasztott-szak' => 'ELTE IK - Programtervező informatikus',
            'erettsegi-eredmenyek' => [
                [
                    'nev' => 'magyar nyelv és irodalom',
                    'tipus' => 'közép',
                    'eredmeny' => '70%',
                ],
                [
                    'nev' => 'történelem',
                    'tipus' => 'közép',
                    'eredmeny' => '80%',
                ],
                [
                    'nev' => 'matematika',
                    'tipus' => 'emelt',
                    'eredmeny' => '90%',
                ],
                [
                    'nev' => 'angol nyelv',
                    'tipus' => 'közép',
                    'eredmeny' => '94%',
                ],
                [
                    'nev' => 'informatika',
                    'tipus' => 'közép',
                    'eredmeny' => '95%',
                ],
                [
                    'nev' => 'fizika',
                    'tipus' => 'közép',
                    'eredmeny' => '98%',
                ],
            ],
            'tobbletpontok' => [
                [
                    'kategoria' => 'Nyelvvizsga',
                    'tipus' => 'B2',
                    'nyelv' => 'angol',
                ],
                [
                    'kategoria' => 'Nyelvvizsga',
                    'tipus' => 'C1',
                    'nyelv' => 'német',
                ],
            ],
        ];

        $departmentName = $data['valasztott-szak'];
        $results = $data['erettsegi-eredmenyek'];
        $extraPoints = $data['tobbletpontok'];*/

        $department = Department::where('name', $departmentName)->with('subjects')->firstOrFail();
        //dd($department);
        try {
            $this->validateResults($department, $results);
        } catch (\Throwable $th) {

            return response()->json([
                'valid' => false,
                'message' => $th->getMessage()
            ]);
        }

        $totalPoints = 0;
        $calculatorFactory = new PointCalculatorFactory($department);

        /** A kötelező tárgy pontszámítása */
        $requiredSubjectCalculator = $calculatorFactory->createRequiredSubjectCalculator();
        $totalPoints += $requiredSubjectCalculator->calculate($results);

        /** A legmagasabb opcionális tárgy számolása */
        $highestOptionalSubjectCalculator = $calculatorFactory->createHighestOptionalSubjectCalculator();
        $totalPoints += $highestOptionalSubjectCalculator->calculate($results);

        /** Extra pontok számolása - nincs lefejlesztve */
        $extraSubjectPointCalculator = $calculatorFactory->createExtraSubjectPointCalculator();
        $totalPoints += $extraSubjectPointCalculator->calculate($results);

        return response()->json([
            'valid' => true,
            'pontszam' => $totalPoints
        ]);
    }

    private function validateResults(Department $department, $results): void
    {

        $basicSubjectValidator = new BasicSubjectValidator();
        $extraSubjectValidator = new ExtraSubjectValidator();

        $validatorService = new ValidatorService($basicSubjectValidator);
        $validatorService->validate($department, $results);

        $validatorService->setValidator($extraSubjectValidator);
        $validatorService->validate($department, $results);
    }
}
