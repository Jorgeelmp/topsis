<?php

namespace Tests\Unit;

use App\Actions\TopsisCalculator;
use App\Enums\CriteriaTypeEnum;
use PHPUnit\Framework\TestCase;

class HwangYoonTopsisReferenceTest extends TestCase
{
    /**
     * Hwang, C.-L.; Yoon, K. Multiple Attribute Decision Making:
     * Methods and Applications: A State-of-the-Art Survey.
     * Springer-Verlag, 1981.
     * Section 2.3.5, TOPSIS.
     * Numerical Example: "The Fighter Aircraft Decision Problem",
     * printed pages 133-134.
     */
    public function test_fighter_aircraft_reference_results(): void
    {
        $decisionMatrix = [
            'A1' => ['X1' => 2.0, 'X2' => 1500, 'X3' => 20000, 'X4' => 5.5, 'X5' => 5, 'X6' => 9],
            'A2' => ['X1' => 2.5, 'X2' => 2700, 'X3' => 18000, 'X4' => 6.5, 'X5' => 3, 'X6' => 5],
            'A3' => ['X1' => 1.8, 'X2' => 2000, 'X3' => 21000, 'X4' => 4.5, 'X5' => 7, 'X6' => 7],
            'A4' => ['X1' => 2.2, 'X2' => 1800, 'X3' => 20000, 'X4' => 5.0, 'X5' => 5, 'X6' => 5],
        ];

        $weights = ['X1' => 0.2, 'X2' => 0.1, 'X3' => 0.1, 'X4' => 0.1, 'X5' => 0.2, 'X6' => 0.3];
        $criteriaTypes = [
            'X1' => CriteriaTypeEnum::BENEFIT,
            'X2' => CriteriaTypeEnum::BENEFIT,
            'X3' => CriteriaTypeEnum::BENEFIT,
            'X4' => CriteriaTypeEnum::COST,
            'X5' => CriteriaTypeEnum::BENEFIT,
            'X6' => CriteriaTypeEnum::BENEFIT,
        ];

        $result = (new TopsisCalculator)->calculate($decisionMatrix, $weights, $criteriaTypes);

        $expectedNormalizedMatrix = [
            'A1' => ['X1' => 0.4671, 'X2' => 0.3662, 'X3' => 0.5056, 'X4' => 0.5063, 'X5' => 0.4811, 'X6' => 0.6708],
            'A2' => ['X1' => 0.5839, 'X2' => 0.6591, 'X3' => 0.4550, 'X4' => 0.5983, 'X5' => 0.2887, 'X6' => 0.3727],
            'A3' => ['X1' => 0.4204, 'X2' => 0.4882, 'X3' => 0.5308, 'X4' => 0.4143, 'X5' => 0.6736, 'X6' => 0.5217],
            'A4' => ['X1' => 0.5139, 'X2' => 0.4392, 'X3' => 0.5056, 'X4' => 0.4603, 'X5' => 0.4811, 'X6' => 0.3727],
        ];
        $expectedWeightedMatrix = [
            'A1' => ['X1' => 0.0934, 'X2' => 0.0366, 'X3' => 0.0506, 'X4' => 0.0506, 'X5' => 0.0962, 'X6' => 0.2012],
            'A2' => ['X1' => 0.1168, 'X2' => 0.0659, 'X3' => 0.0455, 'X4' => 0.0598, 'X5' => 0.0577, 'X6' => 0.1118],
            'A3' => ['X1' => 0.0841, 'X2' => 0.0488, 'X3' => 0.0531, 'X4' => 0.0414, 'X5' => 0.1347, 'X6' => 0.1565],
            'A4' => ['X1' => 0.1028, 'X2' => 0.0439, 'X3' => 0.0506, 'X4' => 0.0460, 'X5' => 0.0962, 'X6' => 0.1118],
        ];
        $expectedIdealSolutions = [
            'positive' => ['X1' => 0.1168, 'X2' => 0.0659, 'X3' => 0.0531, 'X4' => 0.0414, 'X5' => 0.1347, 'X6' => 0.2012],
            'negative' => ['X1' => 0.0841, 'X2' => 0.0366, 'X3' => 0.0455, 'X4' => 0.0598, 'X5' => 0.0577, 'X6' => 0.1118],
        ];
        $expectedDistances = [
            'A1' => ['distance_positive' => 0.0545, 'distance_negative' => 0.0983],
            'A2' => ['distance_positive' => 0.1197, 'distance_negative' => 0.0439],
            'A3' => ['distance_positive' => 0.0580, 'distance_negative' => 0.0920],
            'A4' => ['distance_positive' => 0.1009, 'distance_negative' => 0.0458],
        ];
        $expectedScores = ['A1' => 0.643, 'A2' => 0.268, 'A3' => 0.613, 'A4' => 0.312];

        $this->assertMatrixEqualsWithDelta($expectedNormalizedMatrix, $result['normalized_matrix']);
        $this->assertMatrixEqualsWithDelta($expectedWeightedMatrix, $result['weighted_matrix']);
        $this->assertMatrixEqualsWithDelta($expectedIdealSolutions, $result['ideal_solutions']);
        $this->assertMatrixEqualsWithDelta($expectedDistances, $result['distances']);
        foreach ($expectedScores as $alternative => $expectedScore) {
            $this->assertEqualsWithDelta($expectedScore, $result['scores'][$alternative], 0.001, $alternative);
        }

        $this->assertSame(['A1', 'A3', 'A4', 'A2'], array_keys($result['scores']));
    }

    private function assertMatrixEqualsWithDelta(array $expected, array $actual): void
    {
        foreach ($expected as $alternative => $criteria) {
            foreach ($criteria as $criterion => $expectedValue) {
                $this->assertEqualsWithDelta(
                    $expectedValue,
                    $actual[$alternative][$criterion],
                    0.001,
                    $alternative . '.' . $criterion,
                );
            }
        }
    }
}
