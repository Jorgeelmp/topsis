<?php

namespace App\Models;

use App\Enums\CriteriaTypeEnum;
use App\Enums\ProfessionalFieldsEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'professional_field', 'weight', 'type'])]
class Criteria extends Model
{
    public function casts(): array
    {
        return [
            'type' => CriteriaTypeEnum::class,
            'professional_field' => ProfessionalFieldsEnum::class,
        ];
    }
}
