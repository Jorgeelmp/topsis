<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\ProfessionalProfile;
use App\Models\Review;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@topsis.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role' => RolesEnum::ADMIN,
                'latitude' => -28.702391492581,
                'longitude' => -49.408516371623,
            ]
        );

        $categoryNames = [
            'Diarista',
            'Pedreiro',
            'Pintor',
            'Eletricista',
            'Encanador',
            'Marceneiro',
            'Jardineiro',
            'Chaveiro',
            'Dedetizador',
            'Técnico em Informática',
        ];

        foreach ($categoryNames as $name) {
            ServiceCategory::firstOrCreate(['name' => $name]);
        }

        $clients = User::factory()->client()->count(20)->create();

        $testClient = User::firstOrCreate(
            ['email' => 'cliente@topsis.com'],
            [
                'name' => 'Cliente Teste',
                'password' => Hash::make('password'),
                'role' => RolesEnum::CLIENT,
                'latitude' => -28.710000,
                'longitude' => -49.420000,
            ]
        );

        $clients = $clients->push($testClient);

        $professionals = User::factory()->professional()->count(15)->create();

        $testProfessional = User::firstOrCreate(
            ['email' => 'profissional@topsis.com'],
            [
                'name' => 'Profissional Teste',
                'password' => Hash::make('password'),
                'role' => RolesEnum::PROFESSIONAL,
                'latitude' => -28.720000,
                'longitude' => -49.430000,
            ]
        );

        $professionals = $professionals->push($testProfessional);

        foreach ($professionals as $professional) {
            if (!$professional->professionalProfile) {
                ProfessionalProfile::factory()->create([
                    'user_id' => $professional->id,
                ]);
            }
        }

        foreach ($professionals as $professional) {
            $reviewCount = rand(5, 15);

            $reviewers = $clients->shuffle()->take($reviewCount);

            foreach ($reviewers as $client) {
                Review::firstOrCreate(
                    [
                        'reviewer_id' => $client->id,
                        'reviewed_user_id' => $professional->id,
                    ],
                    [
                        'rating' => rand(1, 5),
                        'comment' => $this->randomComment(rand(1, 5)),
                    ]
                );
            }
        }

        $this->command->info('Seeder concluído!');
        $this->command->table(
            ['Tipo', 'Quantidade'],
            [
                ['Clientes', $clients->count()],
                ['Profissionais', $professionals->count()],
                ['Avaliações', Review::count()],
                ['Categorias', ServiceCategory::count()],
            ]
        );
    }

    private function randomComment(int $rating): ?string
    {
        if (rand(0, 100) > 80) {
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

        return $comments[$rating][array_rand($comments[$rating])];
    }
}
