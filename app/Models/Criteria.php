<?php

namespace App\Models;

use App\Enums\CriteriaTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'weight', 'type'])]
class Criteria extends Model
{
    public function casts(): array
    {
        return [
            'type' => CriteriaTypeEnum::class,
        ];
    }
}
