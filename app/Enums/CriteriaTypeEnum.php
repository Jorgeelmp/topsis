<?php

namespace App\Enums;

enum CriteriaTypeEnum: string
{
    case COST = 'cost';
    case BENEFIT = 'benefit';

    public function label(): string
    {
        return match ($this) {
            self::COST => 'Custo',
            self::BENEFIT => 'Benefício',
        };
    }
}
