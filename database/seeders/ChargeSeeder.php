<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ChargeSeeder extends Seeder
{
    public function run(): void
    {
        $charges = [
            [
                'name' => 'Presidente',
                'description' => 'Máximo responsable de la empresa, no reporta a nadie'
            ],
            [
                'name' => 'Gerente General',
                'description' => 'Responsable de la gestión general de la empresa'
            ],
            [
                'name' => 'Director de Departamento',
                'description' => 'Dirige y supervisa un departamento específico'
            ],
            [
                'name' => 'Jefe de Área',
                'description' => 'Supervisa un área específica dentro del departamento'
            ],
            [
                'name' => 'Coordinador',
                'description' => 'Coordina actividades y equipos de trabajo'
            ],
            [
                'name' => 'Analista Senior',
                'description' => 'Experto en análisis con amplia experiencia'
            ],
            [
                'name' => 'Analista Junior',
                'description' => 'Principiante en análisis, en proceso de aprendizaje'
            ],
            [
                'name' => 'Desarrollador Senior',
                'description' => 'Desarrollador con amplia experiencia técnica'
            ],
            [
                'name' => 'Desarrollador Junior',
                'description' => 'Desarrollador en formación'
            ],
            [
                'name' => 'Asistente Administrativo',
                'description' => 'Brinda soporte administrativo al área'
            ],
        ];

        foreach ($charges as $charge) {
            DB::table('charge')->insert([
                'id' => Uuid::uuid4()->toString(),
                'name' => $charge['name'],
                'description' => $charge['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
