<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FakeDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder utama
        $this->call(DatabaseSeeder::class);

        // Generate 50 user random
        User::factory(50)->create();

        // Generate 1 user khusus untuk testing
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // biar jelas
        ]);

        // Jalankan AttendanceSeeder
        $this->call(AttendanceSeeder::class);
    }
}
