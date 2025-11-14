<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class EmployeeChargeSeeder extends Seeder
{
    public function run(): void
    {
        $chargesCount = DB::table('charge')->count();
        $employeesCount = DB::table('employee')->count();

        if ($chargesCount === 0 || $employeesCount === 0) {
            $this->command->warn('⚠️  No se pueden crear asignaciones. Asegúrate de que ChargeSeeder y EmployeeSeeder se ejecuten correctamente.');
            return;
        }

        $presidenteId = DB::table('charge')->where('name', 'Presidente')->value('id');
        $gerenteId = DB::table('charge')->where('name', 'Gerente General')->value('id');
        $directorId = DB::table('charge')->where('name', 'Director de Departamento')->value('id');
        $jefeAreaId = DB::table('charge')->where('name', 'Jefe de Área')->value('id');
        $coordinadorId = DB::table('charge')->where('name', 'Coordinador')->value('id');

        $employees = DB::table('employee')->get();
        $anaId = $employees->where('identification', '1023456789')->value('id');
        $luisId = $employees->where('identification', '1034567890')->value('id');
        $mariaId = $employees->where('identification', '1045678901')->value('id');
        $robertoId = $employees->where('identification', '1056789012')->value('id');
        $carolinaId = $employees->where('identification', '1067890123')->value('id');

        if (!$anaId || !$luisId || !$mariaId || !$robertoId || !$carolinaId) {
            $this->command->warn('⚠️  No se encontraron todos los empleados necesarios.');
            return;
        }

        $employeeCharges = [
            [
                'employee_id' => $anaId,
                'charge_id' => $presidenteId,
                'area' => 'Dirección General',
                'start_date' => '2023-01-01',
                'boss_id' => null,
                'active' => true,
            ],
            [
                'employee_id' => $luisId,
                'charge_id' => $gerenteId,
                'area' => 'Gerencia',
                'start_date' => '2023-02-01',
                'boss_id' => $anaId,
                'active' => true,
            ],
            [
                'employee_id' => $mariaId,
                'charge_id' => $directorId,
                'area' => 'Tecnología',
                'start_date' => '2023-03-01',
                'boss_id' => $luisId,
                'active' => true,
            ],
            [
                'employee_id' => $robertoId,
                'charge_id' => $jefeAreaId,
                'area' => 'Desarrollo',
                'start_date' => '2023-04-01',
                'boss_id' => $mariaId,
                'active' => true,
            ],
            [
                'employee_id' => $carolinaId,
                'charge_id' => $coordinadorId,
                'area' => 'Proyectos',
                'start_date' => '2023-05-01',
                'boss_id' => $robertoId,
                'active' => true,
            ],
        ];

        $createdCount = 0;
        foreach ($employeeCharges as $employeeCharge) {
            $existingAssignment = DB::table('employee_charge')
                ->where('employee_id', $employeeCharge['employee_id'])
                ->where('charge_id', $employeeCharge['charge_id'])
                ->where('active', true)
                ->first();

            if (!$existingAssignment) {
                DB::table('employee_charge')->insert([
                    'id' => Uuid::uuid4()->toString(),
                    'employee_id' => $employeeCharge['employee_id'],
                    'charge_id' => $employeeCharge['charge_id'],
                    'area' => $employeeCharge['area'],
                    'start_date' => $employeeCharge['start_date'],
                    'boss_id' => $employeeCharge['boss_id'],
                    'active' => $employeeCharge['active'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $createdCount++;
            }
        }
    }
}
