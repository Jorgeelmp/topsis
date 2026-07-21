<?php

namespace App\Actions;

use App\Models\ProfessionalProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GetProfessionalsAction
{
    public function execute(?int $categoryId = null, array $weights = []): LengthAwarePaginator
    {
        $query = ProfessionalProfile::with(['user', 'serviceCategory']);

        if ($categoryId) {
            $query->where('service_category_id', $categoryId);
        }

        // Primeiro passo do TOPSIS: Criar a matriz de decisão com valores crus
        $decisionMatrix = self::createDecisionMatrix($query->get());

        // Segundo passo: Normalização da matriz
        $normalizedMatrix = self::normalizeMatrix($decisionMatrix);

        // @TODO: Implementar os próximos passos do TOPSIS.
        dd('Passo 2: Matriz Normalizada', $normalizedMatrix);

        return $query->paginate(10)->withQueryString();
    }

    public static function createDecisionMatrix(Collection $professionals): array
    {
        $decisionMatrix = [];
        foreach ($professionals as $professional) {
            $decisionMatrix[$professional->id] = [
                'hourly_price' => (float) $professional->hourly_price,
                'response_time' => (float) $professional->response_time,
                'experience_years' => (float) $professional->experience_years,
                'acceptance_rate' => (float) $professional->acceptance_rate,
                'reviews_count' => (float) $professional->reviews_count,
                'average_rating' => (float) $professional->average_rating,
            ];
        }

        return $decisionMatrix;
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
}
