<?php

namespace App\Actions;

use App\Enums\CriteriaTypeEnum;
use App\Models\Criteria;
use App\Models\ProfessionalProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GetProfessionalsAction
{
    public function execute(?int $categoryId = null, array $weights = []): LengthAwarePaginator
    {
        $query = ProfessionalProfile::with(['user', 'serviceCategory']);

        if (!is_null($categoryId)) {
            $query->where('service_category_id', $categoryId);
        }

        $professionals = $query->get();

        // Primeiro passo do TOPSIS: Criar a matriz de decisão com valores crus
        $decisionMatrix = self::createDecisionMatrix($professionals);

        // Segundo passo: Normalização da matriz
        $normalizedMatrix = self::normalizeMatrix($decisionMatrix);

        // Terceiro passo: Matriz ponderada
        $weightedMatrix = self::applyWeights($normalizedMatrix, $weights);

        // Quarto passo: Soluções ideais positiva e negativa
        $idealSolutions = self::calculateIdealSolutions($weightedMatrix);

        // Quinto passo: Distâncias para as soluções ideais (Positiva e Negativa)
        $distances = self::calculateDistances($weightedMatrix, $idealSolutions);

        // Sexto passo: Calcular a proximidade relativa (Score TOPSIS) e ordenar
        $scores = self::calculateScores($distances);

        foreach ($professionals as $professional) {
            $professional->topsis_score = $scores[$professional->id] ?? 0;
        }

        $sortedProfessionals = $professionals->sortByDesc('topsis_score')->values();

        $page = request()->input('page', 1);
        $perPage = 10;

        $paginator = new LengthAwarePaginator(
            $sortedProfessionals->forPage($page, $perPage),
            $sortedProfessionals->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginator;
    }

    public static function createDecisionMatrix(Collection $professionals): array
    {
        $currentUser = auth()->user();
        $userLat = $currentUser?->latitude;
        $userLon = $currentUser?->longitude;

        $decisionMatrix = [];
        foreach ($professionals as $professional) {
            $profLat = $professional->user->latitude ?? null;
            $profLon = $professional->user->longitude ?? null;

            $distance = self::calculateHaversineDistance($userLat, $userLon, $profLat, $profLon);

            $decisionMatrix[$professional->id] = [
                'hourly_price' => (float) $professional->hourly_price,
                'response_time' => (float) $professional->response_time,
                'experience_years' => (float) $professional->experience_years,
                'acceptance_rate' => (float) $professional->acceptance_rate,
                'reviews_count' => (float) $professional->reviews_count,
                'average_rating' => (float) $professional->average_rating,
                'distance' => (float) $distance,
            ];
        }

        return $decisionMatrix;
    }

    private static function calculateHaversineDistance($userLat, $userLon, $profLat, $profLon): float
    {
        if (is_null($userLat) || is_null($userLon) || is_null($profLat) || is_null($profLon)) {
            return 999.0;
        }

        $earthRadiusInKilometers = 6371;

        $deltaLatitude = deg2rad($profLat - $userLat);
        $deltaLongitude = deg2rad($profLon - $userLon);

        $chordLengthSquare = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) +
            cos(deg2rad($userLat)) * cos(deg2rad($profLat)) *
            sin($deltaLongitude / 2) * sin($deltaLongitude / 2);

        $angularDistance = 2 * atan2(sqrt($chordLengthSquare), sqrt(1 - $chordLengthSquare));

        $distanceInKilometers = $earthRadiusInKilometers * $angularDistance;

        return $distanceInKilometers;
    }

    public static function normalizeMatrix(array $decisionMatrix): array
    {
        if (empty($decisionMatrix)) {
            return [];
        }

        $normalizedMatrix = [];
        $criteriaNames = array_keys(reset($decisionMatrix));

        // Passo 2.1: Calcular a raiz quadrada da soma dos quadrados para cada critério (denominador)
        $denominatorsByCriterion = [];
        foreach ($criteriaNames as $criterionName) {
            $sumOfSquaresForCriterion = 0;

            foreach ($decisionMatrix as $professionalId => $professionalCriteriaValues) {
                $originalValue = $professionalCriteriaValues[$criterionName];
                $sumOfSquaresForCriterion += pow($originalValue, 2);
            }

            $denominatorsByCriterion[$criterionName] = sqrt($sumOfSquaresForCriterion);
        }

        // Passo 2.2: Dividir cada valor pelo denominador correspondente
        foreach ($decisionMatrix as $professionalId => $professionalCriteriaValues) {
            foreach ($criteriaNames as $criterionName) {
                $originalValue = $professionalCriteriaValues[$criterionName];
                $denominator = $denominatorsByCriterion[$criterionName];

                // r_ij = x_ij / sqrt(sum(x_ij^2))
                $normalizedValue = $denominator != 0 ? ($originalValue / $denominator) : 0;

                $normalizedMatrix[$professionalId][$criterionName] = $normalizedValue;
            }
        }

        return $normalizedMatrix;
    }

    public static function applyWeights(array $normalizedMatrix, array $userWeights = []): array
    {
        if (empty($normalizedMatrix)) {
            return [];
        }

        $weightsByField = self::getWeightsByField($userWeights);

        $weightedMatrix = [];
        foreach ($normalizedMatrix as $professionalId => $professionalCriteriaValues) {
            foreach ($professionalCriteriaValues as $criterionName => $normalizedValue) {
                $weight = $weightsByField[$criterionName];

                // v_ij = r_ij * w_j
                $weightedMatrix[$professionalId][$criterionName] = $normalizedValue * $weight;
            }
        }

        return $weightedMatrix;
    }

    public static function calculateIdealSolutions(array $weightedMatrix): array
    {
        if (empty($weightedMatrix)) {
            return ['positive' => [], 'negative' => []];
        }

        $typeByField = self::getCriteriaTypesByField();

        $idealPositive = [];
        $idealNegative = [];

        $criteriaNames = array_keys(reset($weightedMatrix));

        foreach ($criteriaNames as $criterionName) {
            $values = array_column($weightedMatrix, $criterionName);
            $type = $typeByField[$criterionName] ?? null;

            if ($type === CriteriaTypeEnum::BENEFIT) {
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

    public static function calculateDistances(array $weightedMatrix, array $idealSolutions): array
    {
        $distances = [];
        $idealPositive = $idealSolutions['positive'];
        $idealNegative = $idealSolutions['negative'];

        foreach ($weightedMatrix as $professionalId => $professionalCriteriaValues) {
            $sumSquaresPositive = 0;
            $sumSquaresNegative = 0;

            foreach ($professionalCriteriaValues as $criterionName => $value) {
                // (v_ij - A+_j)^2
                $sumSquaresPositive += pow($value - $idealPositive[$criterionName], 2);

                // (v_ij - A-_j)^2
                $sumSquaresNegative += pow($value - $idealNegative[$criterionName], 2);
            }

            $distances[$professionalId] = [
                'distance_positive' => sqrt($sumSquaresPositive),
                'distance_negative' => sqrt($sumSquaresNegative),
            ];
        }

        return $distances;
    }

    public static function calculateScores(array $distances): array
    {
        $scores = [];

        foreach ($distances as $professionalId => $distanceData) {
            $sPositive = $distanceData['distance_positive'];
            $sNegative = $distanceData['distance_negative'];

            // Ci = S- / (S+ + S-)
            $totalDistance = $sPositive + $sNegative;

            $score = $totalDistance > 0 ? ($sNegative / $totalDistance) : 0;

            $scores[$professionalId] = $score;
        }

        arsort($scores);

        return $scores;
    }

    private static function getWeightsByField(array $userWeights): array
    {
        $weightsByField = [];

        foreach (Criteria::all() as $criteria) {
            $field = $criteria->professional_field->value;
            $weightsByField[$field] = (float) ($userWeights[$criteria->id] ?? 0);
        }

        return $weightsByField;
    }

    private static function getCriteriaTypesByField(): array
    {
        $typeByField = [];

        foreach (Criteria::all() as $criteria) {
            $field = $criteria->professional_field->value;
            $typeByField[$field] = $criteria->type;
        }

        return $typeByField;
    }
}
