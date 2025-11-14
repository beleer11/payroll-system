<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'Colombia', 'code' => 'CO'],
            ['name' => 'México', 'code' => 'MX'],
            ['name' => 'Argentina', 'code' => 'AR'],
            ['name' => 'España', 'code' => 'ES'],
            ['name' => 'Chile', 'code' => 'CL'],
            ['name' => 'Perú', 'code' => 'PE'],
            ['name' => 'Ecuador', 'code' => 'EC'],
            ['name' => 'Venezuela', 'code' => 'VE'],
        ];

        foreach ($countries as $country) {
            DB::table('country')->insert([
                'id' => Uuid::uuid4()->toString(),
                'name' => $country['name'],
                'code' => $country['code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
