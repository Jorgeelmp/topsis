<?php

namespace App\Enums;

enum ProfessionalFieldsEnum: string
{
    case HOURLY_PRICE = 'hourly_price';
    case RESPONSE_TIME = 'response_time';
    case EXPERIENCE_YEARS = 'experience_years';
    case ACCEPTANCE_RATE = 'acceptance_rate';
    case REVIEWS_COUNT = 'reviews_count';
    case AVERAGE_RATING = 'average_rating';

    public function label(): string
    {
        return match ($this) {
            self::HOURLY_PRICE => 'Valor/Hora',
            self::RESPONSE_TIME => 'Tempo de Resposta',
            self::EXPERIENCE_YEARS => 'Anos de Experiência',
            self::ACCEPTANCE_RATE => 'Taxa de Aceite',
            self::REVIEWS_COUNT => 'Quantidade de Avaliações',
            self::AVERAGE_RATING => 'Nota Média das Avaliações',
        };
    }
}
