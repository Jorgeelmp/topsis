<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
