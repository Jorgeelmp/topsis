<?php

namespace App\Actions;

use App\Models\ProfessionalProfile;
use Illuminate\Pagination\LengthAwarePaginator;

class GetProfessionalsAction
{
    public function execute(?int $categoryId = null, array $weights = []): LengthAwarePaginator
    {
        $query = ProfessionalProfile::with(['user', 'serviceCategory']);

        if ($categoryId) {
            $query->where('service_category_id', $categoryId);
        }

        // @TODO: adicionar TOPSIS aqui

        return $query->paginate(12)->withQueryString();
    }
}
