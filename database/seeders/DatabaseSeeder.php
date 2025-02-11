<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        try {
            // User
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        } catch (\Exception $e) {
        }


        // Dinas Faker
        try {
            $this->call(DinasSeeder::class);
        } catch (\Exception $e) {
        }

        // Kegiatan Faker
        try {
            $this->call(KegiatanSeeder::class);
        } catch (\Exception $e) {
        }
    }
}
