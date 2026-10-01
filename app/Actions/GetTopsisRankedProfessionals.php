<?php

namespace App\Actions;

use App\Models\Criteria;
use App\Models\ProfessionalProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GetTopsisRankedProfessionals
{
    public function execute(?int $categoryId = null, array $weights = []): LengthAwarePaginator
    {
        $query = ProfessionalProfile::with(['user', 'serviceCategory']);

        if (!is_null($categoryId)) {
            $query->where('service_category_id', $categoryId);
        }

        $professionals = $query->get();

        // Primeiro passo do TOPSIS: Criar a matriz de decisão com valores originais
        $decisionMatrix = self::createDecisionMatrix($professionals);

        $calculator = new TopsisCalculator;
        $calculation = $calculator->calculate(
            $decisionMatrix,
            self::getWeightsByField($weights),
            self::getCriteriaTypesByField(),
        );
        $scores = $calculation['scores'];

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
            $professional->distance_to_user = $distance;

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
