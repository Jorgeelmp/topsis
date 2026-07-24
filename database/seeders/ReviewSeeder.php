<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        $faker->seed(9012);

        $clients = User::where('role', RolesEnum::CLIENT)->get();
        $professionals = User::where('role', RolesEnum::PROFESSIONAL)->with('professionalProfile')->get();

        if ($clients->isEmpty() || $professionals->isEmpty()) {
            return;
        }

        foreach ($professionals as $professional) {
            $reviewCount = $faker->numberBetween(5, 15);

            $selectedClients = $faker->randomElements($clients->toArray(), $reviewCount);

            $totalRating = 0;

            foreach ($selectedClients as $clientArray) {
                $rating = $faker->numberBetween(1, 5);
                $totalRating += $rating;

                Review::firstOrCreate(
                    [
                        'reviewer_id' => $clientArray['id'],
                        'reviewed_user_id' => $professional->id,
                    ],
                    [
                        'rating' => $rating,
                        'comment' => $this->randomComment($rating, $faker),
                    ]
                );
            }

        }
    }

    private function randomComment(int $rating, \Faker\Generator $faker): ?string
    {
        if ($faker->numberBetween(0, 100) > 80) {
            return null;
        }

        $comments = [
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

        return $faker->randomElement($comments[$rating]);
    }
}
