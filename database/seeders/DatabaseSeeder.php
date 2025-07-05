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

        $this->call([
            ZodiacSeeder::class,
            ContactSeeder::class,
        ]);

        // Create admin user only if doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Check by email
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'), // Default password
            ]
        );
    }
}
