<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker bahasa Indonesia

        for ($i = 1; $i <= 10; $i++) {
            DB::table('dinas')->insert([
                'kode' => $i, // Kode unik bertambah
                'nama' => $faker->company, // Nama dinas acak
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
