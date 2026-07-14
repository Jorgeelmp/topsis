<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    private static array $comments = [
        5 => [
            'Excelente profissional! Trabalho impecável e muito pontual.',
            'Superou todas as expectativas. Recomendo muito!',
            'Serviço de altíssima qualidade. Com certeza contrataria novamente.',
            'Profissional exemplar, muito atencioso e dedicado.',
            'Trabalho perfeito! Ficou exatamente como eu queria.',
        ],
        4 => [
            'Muito bom profissional, cumpriu com o combinado.',
            'Trabalho bem feito, prazo atendido. Gostei bastante.',
            'Boa experiência no geral, recomendo.',
            'Profissional competente e educado.',
            'Serviço de boa qualidade, ficou satisfeito.',
        ],
        3 => [
            'Trabalho razoável, dentro do esperado.',
            'Atendeu o básico, mas poderia ter sido mais caprichoso.',
            'Profissional ok, mas o prazo demorou um pouco mais.',
            'Resultado satisfatório, porém com pequenos ajustes necessários.',
            'Serviço mediano, esperava um pouco mais.',
        ],
        2 => [
            'Não ficou muito satisfeito, houve atrasos.',
            'Qualidade abaixo do esperado, precisei refazer algumas partes.',
            'Comunicação falhou em alguns momentos.',
            'O resultado final deixou a desejar.',
            'Profissional pouco comprometido com o prazo.',
        ],
        1 => [
            'Muito insatisfeito com o serviço prestado.',
            'Trabalho muito abaixo do que foi prometido.',
            'Não recomendo, tive vários problemas.',
            'Pior experiência que tive. Não cumpriu o que foi combinado.',
            'Serviço péssimo, terei que contratar outro profissional.',
        ],
    ];

    public function definition(): array
    {
        $rating = fake()->numberBetween(1, 5);

        return [
            'rating' => $rating,
            'comment' => fake()->boolean(80)
                ? fake()->randomElement(self::$comments[$rating])
                : null,
        ];
    }
}
