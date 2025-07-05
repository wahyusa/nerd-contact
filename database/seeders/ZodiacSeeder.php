<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zodiac;

class ZodiacSeeder extends Seeder
{
    public function run(): void
    {
        // Check if zodiacs already exist
        if (Zodiac::count() > 0) {
            $this->command->info('Zodiacs already exist. Skipping...');
            return;
        }

        $zodiacs = [
            ['name' => 'Aries', 'symbol' => '♈', 'element' => 'Fire', 'start_date' => '2024-03-21', 'end_date' => '2024-04-19'],
            ['name' => 'Taurus', 'symbol' => '♉', 'element' => 'Earth', 'start_date' => '2024-04-20', 'end_date' => '2024-05-20'],
            ['name' => 'Gemini', 'symbol' => '♊', 'element' => 'Air', 'start_date' => '2024-05-21', 'end_date' => '2024-06-20'],
            ['name' => 'Cancer', 'symbol' => '♋', 'element' => 'Water', 'start_date' => '2024-06-21', 'end_date' => '2024-07-22'],
            ['name' => 'Leo', 'symbol' => '♌', 'element' => 'Fire', 'start_date' => '2024-07-23', 'end_date' => '2024-08-22'],
            ['name' => 'Virgo', 'symbol' => '♍', 'element' => 'Earth', 'start_date' => '2024-08-23', 'end_date' => '2024-09-22'],
            ['name' => 'Libra', 'symbol' => '♎', 'element' => 'Air', 'start_date' => '2024-09-23', 'end_date' => '2024-10-22'],
            ['name' => 'Scorpio', 'symbol' => '♏', 'element' => 'Water', 'start_date' => '2024-10-23', 'end_date' => '2024-11-21'],
            ['name' => 'Sagittarius', 'symbol' => '♐', 'element' => 'Fire', 'start_date' => '2024-11-22', 'end_date' => '2024-12-21'],
            ['name' => 'Capricorn', 'symbol' => '♑', 'element' => 'Earth', 'start_date' => '2024-12-22', 'end_date' => '2024-01-19'],
            ['name' => 'Aquarius', 'symbol' => '♒', 'element' => 'Air', 'start_date' => '2024-01-20', 'end_date' => '2024-02-18'],
            ['name' => 'Pisces', 'symbol' => '♓', 'element' => 'Water', 'start_date' => '2024-02-19', 'end_date' => '2024-03-20'],
        ];

        foreach ($zodiacs as $zodiac) {
            Zodiac::firstOrCreate(
                ['name' => $zodiac['name']], // Check for existing by name
                $zodiac // Create with all data if not found
            );
        }

        $this->command->info('Zodiac signs seeded successfully!');
    }
}