<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $colombiaId = DB::table('country')->where('name', 'Colombia')->value('id');
        $bogotaId = DB::table('city')->where('name', 'Bogotá')->value('id');
        if (!$colombiaId || !$bogotaId) {
            $this->command->warn('⚠️  No se encontraron país o ciudad. Asegúrate de que CountrySeeder y CitySeeder se ejecuten correctamente.');
            return;
        }

        $employees = [
            [
                'name' => 'Ana',
                'lastname' => 'García López',
                'identification' => '1023456789',
                'address' => 'Calle 123 #45-67, Bogotá',
                'phone' => '3101234567',
                'birthplace_id' => $bogotaId,
                'country_id' => $colombiaId,
            ],
            [
                'name' => 'Luis',
                'lastname' => 'Martínez Rojas',
                'identification' => '1034567890',
                'address' => 'Avenida 68 #12-34, Bogotá',
                'phone' => '3202345678',
                'birthplace_id' => $bogotaId,
                'country_id' => $colombiaId,
            ],
            [
                'name' => 'María',
                'lastname' => 'Hernández Silva',
                'identification' => '1045678901',
                'address' => 'Carrera 15 #78-90, Bogotá',
                'phone' => '3153456789',
                'birthplace_id' => $bogotaId,
                'country_id' => $colombiaId,
            ],
            [
                'name' => 'Roberto',
                'lastname' => 'Díaz Mendoza',
                'identification' => '1056789012',
                'address' => 'Transversal 23 #56-78, Bogotá',
                'phone' => '3004567890',
                'birthplace_id' => $bogotaId,
                'country_id' => $colombiaId,
            ],
            [
                'name' => 'Carolina',
                'lastname' => 'Ramírez Castro',
                'identification' => '1067890123',
                'address' => 'Diagonal 34 #67-89, Bogotá',
                'phone' => '3185678901',
                'birthplace_id' => $bogotaId,
                'country_id' => $colombiaId,
            ],
        ];

        foreach ($employees as $employee) {
            $existingEmployee = DB::table('employee')
                ->where('identification', $employee['identification'])
                ->first();

            if (!$existingEmployee) {
                DB::table('employee')->insert([
                    'id' => Uuid::uuid4()->toString(),
                    'name' => $employee['name'],
                    'lastname' => $employee['lastname'],
                    'identification' => $employee['identification'],
                    'address' => $employee['address'],
                    'phone' => $employee['phone'],
                    'birthplace_id' => $employee['birthplace_id'],
                    'country_id' => $employee['country_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('✅ EmployeeSeeder completado. ' . count($employees) . ' empleados creados/verificados.');
    }
}
