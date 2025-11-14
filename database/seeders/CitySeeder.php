<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $colombiaId = DB::table('country')->where('code', 'CO')->value('id');
        $mexicoId = DB::table('country')->where('code', 'MX')->value('id');
        $argentinaId = DB::table('country')->where('code', 'AR')->value('id');
        $spainId = DB::table('country')->where('code', 'ES')->value('id');
        $chileId = DB::table('country')->where('code', 'CL')->value('id');

        $cities = [
            // Colombia
            ['name' => 'Bogotá', 'country_id' => $colombiaId],
            ['name' => 'Medellín', 'country_id' => $colombiaId],
            ['name' => 'Cali', 'country_id' => $colombiaId],
            ['name' => 'Barranquilla', 'country_id' => $colombiaId],
            ['name' => 'Cartagena', 'country_id' => $colombiaId],
            ['name' => 'Bucaramanga', 'country_id' => $colombiaId],

            // México
            ['name' => 'Ciudad de México', 'country_id' => $mexicoId],
            ['name' => 'Guadalajara', 'country_id' => $mexicoId],
            ['name' => 'Monterrey', 'country_id' => $mexicoId],
            ['name' => 'Puebla', 'country_id' => $mexicoId],
            ['name' => 'Cancún', 'country_id' => $mexicoId],

            // Argentina
            ['name' => 'Buenos Aires', 'country_id' => $argentinaId],
            ['name' => 'Córdoba', 'country_id' => $argentinaId],
            ['name' => 'Rosario', 'country_id' => $argentinaId],
            ['name' => 'Mendoza', 'country_id' => $argentinaId],

            // España
            ['name' => 'Madrid', 'country_id' => $spainId],
            ['name' => 'Barcelona', 'country_id' => $spainId],
            ['name' => 'Valencia', 'country_id' => $spainId],
            ['name' => 'Sevilla', 'country_id' => $spainId],

            // Chile
            ['name' => 'Santiago', 'country_id' => $chileId],
            ['name' => 'Valparaíso', 'country_id' => $chileId],
            ['name' => 'Concepción', 'country_id' => $chileId],
        ];

        foreach ($cities as $city) {
            DB::table('city')->insert([
                'id' => Uuid::uuid4()->toString(),
                'name' => $city['name'],
                'country_id' => $city['country_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
