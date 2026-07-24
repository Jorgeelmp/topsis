<?php

namespace Database\Seeders;

use App\Enums\CriteriaTypeEnum;
use App\Enums\ProfessionalFieldsEnum;
use App\Enums\RolesEnum;
use App\Models\Criteria;
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

        $this->call([
            CategorySeeder::class,
            ClientSeeder::class,
            ProfessionalSeeder::class,
            ReviewSeeder::class,
        ]);

        $criterias = [
            ['name' => 'Valor/Hora', 'type' => CriteriaTypeEnum::COST, 'weight' => 0.25, 'professional_field' => ProfessionalFieldsEnum::HOURLY_PRICE],
            ['name' => 'Tempo de Resposta', 'type' => CriteriaTypeEnum::COST, 'weight' => 0.1, 'professional_field' => ProfessionalFieldsEnum::RESPONSE_TIME],
            ['name' => 'Anos de Experiência', 'type' => CriteriaTypeEnum::BENEFIT, 'weight' => 0.2, 'professional_field' => ProfessionalFieldsEnum::EXPERIENCE_YEARS],
            ['name' => 'Taxa de Aceite', 'type' => CriteriaTypeEnum::BENEFIT, 'weight' => 0.15, 'professional_field' => ProfessionalFieldsEnum::ACCEPTANCE_RATE],
            ['name' => 'Quantidade de Avaliações', 'type' => CriteriaTypeEnum::BENEFIT, 'weight' => 0.05, 'professional_field' => ProfessionalFieldsEnum::REVIEWS_COUNT],
            ['name' => 'Nota Média das Avaliações', 'type' => CriteriaTypeEnum::BENEFIT, 'weight' => 0.2, 'professional_field' => ProfessionalFieldsEnum::AVERAGE_RATING],
            ['name' => 'Distância', 'type' => CriteriaTypeEnum::COST, 'weight' => 0.05, 'professional_field' => ProfessionalFieldsEnum::DISTANCE],
        ];

        foreach ($criterias as $criteria) {
            Criteria::firstOrCreate(['professional_field' => $criteria['professional_field']], $criteria);
        }

        $this->command->info('Seeder concluído!');
    }
}
