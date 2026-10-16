<?php

namespace App\Actions;

use App\Enums\CriteriaTypeEnum;

class TopsisCalculator
{
    public function calculate(array $decisionMatrix, array $weights, array $criteriaTypes): array
    {
        // Segundo passo: Normalização da matriz
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);

        // Terceiro passo: Matriz ponderada
        $weightedMatrix = $this->applyWeights($normalizedMatrix, $weights);

        // Quarto passo: Soluções ideais positiva e negativa
        $idealSolutions = $this->calculateIdealSolutions($weightedMatrix, $criteriaTypes);

        // Quinto passo: Distâncias para as soluções ideais (Positiva e Negativa)
        $distances = $this->calculateDistances($weightedMatrix, $idealSolutions);

        // Sexto passo: Calcular a proximidade relativa (Score TOPSIS) e ordenar
        $scores = $this->calculateScores($distances);

        return [
            'normalized_matrix' => $normalizedMatrix,
            'weighted_matrix' => $weightedMatrix,
            'ideal_solutions' => $idealSolutions,
            'distances' => $distances,
            'scores' => $scores,
        ];
    }

    public function normalizeMatrix(array $decisionMatrix): array
    {
        if (empty($decisionMatrix)) {
            return [];
        }

        $normalizedMatrix = [];
        $criteriaNames = array_keys(reset($decisionMatrix));
        $denominatorsByCriterion = [];

        foreach ($criteriaNames as $criterionName) {
            $sumOfSquares = 0;

            foreach ($decisionMatrix as $professionalCriteriaValues) {
                $sumOfSquares += pow($professionalCriteriaValues[$criterionName], 2);
            }

            $denominatorsByCriterion[$criterionName] = sqrt($sumOfSquares);
        }

        foreach ($decisionMatrix as $alternativeId => $alternativeCriteriaValues) {
            foreach ($criteriaNames as $criterionName) {
                $denominator = $denominatorsByCriterion[$criterionName];
                $value = $alternativeCriteriaValues[$criterionName];

                $normalizedMatrix[$alternativeId][$criterionName] = $denominator != 0
                    ? ($value / $denominator)
                    : 0;
            }
        }

        return $normalizedMatrix;
    }

    public function applyWeights(array $normalizedMatrix, array $weights): array
    {
        if (empty($normalizedMatrix)) {
            return [];
        }

        $weightedMatrix = [];

        foreach ($normalizedMatrix as $alternativeId => $alternativeCriteriaValues) {
            foreach ($alternativeCriteriaValues as $criterionName => $normalizedValue) {
                $weightedMatrix[$alternativeId][$criterionName] = $normalizedValue * ($weights[$criterionName] ?? 0);
            }
        }

        return $weightedMatrix;
    }

    public function calculateIdealSolutions(array $weightedMatrix, array $criteriaTypes): array
    {
        if (empty($weightedMatrix)) {
            return ['positive' => [], 'negative' => []];
        }

        $idealPositive = [];
        $idealNegative = [];
        $criteriaNames = array_keys(reset($weightedMatrix));

        foreach ($criteriaNames as $criterionName) {
            $values = array_column($weightedMatrix, $criterionName);
            $isBenefit = ($criteriaTypes[$criterionName] ?? null) === CriteriaTypeEnum::BENEFIT;

            if ($isBenefit) {
                $idealPositive[$criterionName] = max($values);
                $idealNegative[$criterionName] = min($values);
            } else {
                $idealPositive[$criterionName] = min($values);
                $idealNegative[$criterionName] = max($values);
            }
        }

        return [
            'positive' => $idealPositive,
            'negative' => $idealNegative,
        ];
    }

    public function calculateDistances(array $weightedMatrix, array $idealSolutions): array
    {
        $distances = [];
        $idealPositive = $idealSolutions['positive'];
        $idealNegative = $idealSolutions['negative'];

        foreach ($weightedMatrix as $alternativeId => $alternativeCriteriaValues) {
            $sumSquaresPositive = 0;
            $sumSquaresNegative = 0;

            foreach ($alternativeCriteriaValues as $criterionName => $value) {
                $sumSquaresPositive += pow($value - $idealPositive[$criterionName], 2);
                $sumSquaresNegative += pow($value - $idealNegative[$criterionName], 2);
            }

            $distances[$alternativeId] = [
                'distance_positive' => sqrt($sumSquaresPositive),
                'distance_negative' => sqrt($sumSquaresNegative),
            ];
        }

        return $distances;
    }

    public function calculateScores(array $distances): array
    {
        $scores = [];

        foreach ($distances as $alternativeId => $distanceData) {
            $totalDistance = $distanceData['distance_positive'] + $distanceData['distance_negative'];
            $scores[$alternativeId] = $totalDistance > 0
                ? ($distanceData['distance_negative'] / $totalDistance)
                : 0;
        }

        arsort($scores);

        return $scores;
    }
}