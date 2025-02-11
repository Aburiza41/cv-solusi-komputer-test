<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker bahasa Indonesia

        for ($i = 1; $i <= 10; $i++) {
            DB::table('kegiatan')->insert([
                'kode' => str_pad($i, 5, '0', STR_PAD_LEFT), // Kode dengan format 3 digit (001, 002, ...)
                'nama' => $faker->sentence(3), // Nama kegiatan acak (3 kata)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
