<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Zodiac;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        // Check if contacts already exist
        if (Contact::count() > 0) {
            $this->command->info('Contacts already exist. Skipping...');
            return;
        }

        $faker = Faker::create();
        $zodiacs = Zodiac::all();

        // Predefined tags for more realistic data
        $availableTags = [
            'friend',
            'family',
            'coworker',
            'neighbor',
            'classmate',
            'nerd',
            'gamer',
            'developer',
            'designer',
            'musician',
            'sports',
            'travel',
            'foodie',
            'bookworm',
            'artist',
            'close',
            'acquaintance',
            'online-friend',
            'mentor',
            'student'
        ];

        // Social platforms for realistic links
        $socialPlatforms = [
            'github',
            'twitter',
            'linkedin',
            'instagram',
            'facebook',
            'discord',
            'youtube',
            'twitch',
            'reddit',
            'tiktok'
        ];

        $usedEmails = [];
        $contactsCreated = 0;

        while ($contactsCreated < 100) {
            // Generate unique email
            $email = $faker->unique()->safeEmail();
            if (in_array($email, $usedEmails)) {
                continue;
            }
            $usedEmails[] = $email;

            // Random chance to have incomplete data (30% chance)
            $isIncomplete = $faker->boolean(30);

            // Generate birth date (some contacts won't have it)
            $birthDate = null;
            $zodiacId = null;
            if (!$isIncomplete || $faker->boolean(70)) { // 70% chance to have birth date even if incomplete
                $birthDate = $faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d');

                // 80% chance to have zodiac if birth date exists
                if ($faker->boolean(80) && $zodiacs->count() > 0) {
                    $zodiacId = $zodiacs->random()->id;
                }
            }

            // Generate tags (1-5 random tags)
            $contactTags = null;
            if (!$isIncomplete || $faker->boolean(60)) {
                $numTags = $faker->numberBetween(1, 5);
                $contactTags = $faker->randomElements($availableTags, $numTags);
            }

            // Generate social links (0-4 platforms)
            $socialLinks = null;
            if (!$isIncomplete || $faker->boolean(50)) {
                $numSocials = $faker->numberBetween(0, 4);
                $selectedPlatforms = $faker->randomElements($socialPlatforms, $numSocials);

                $socialLinks = [];
                foreach ($selectedPlatforms as $platform) {
                    $username = $faker->userName();
                    switch ($platform) {
                        case 'github':
                            $socialLinks[$platform] = "https://github.com/{$username}";
                            break;
                        case 'twitter':
                            $socialLinks[$platform] = "https://twitter.com/{$username}";
                            break;
                        case 'linkedin':
                            $socialLinks[$platform] = "https://linkedin.com/in/{$username}";
                            break;
                        case 'instagram':
                            $socialLinks[$platform] = "https://instagram.com/{$username}";
                            break;
                        case 'discord':
                            $socialLinks[$platform] = "{$username}#{$faker->numberBetween(1000, 9999)}";
                            break;
                        default:
                            $socialLinks[$platform] = "https://{$platform}.com/{$username}";
                    }
                }
            }

            $contact = [
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $email,
                'phone' => $isIncomplete && $faker->boolean(50) ? null : $faker->phoneNumber(),
                'avatar' => null, // Will be handled by file upload in the app
                'birth_date' => $birthDate,
                'zodiac_id' => $zodiacId,
                'description' => $isIncomplete && $faker->boolean(40) ? null : $faker->optional(0.7)->paragraph(),
                'social_links' => $socialLinks,
                'tags' => $contactTags,
                'last_meet' => $faker->optional(0.6)->dateTimeBetween('-2 years', 'now'),
            ];

            Contact::create($contact);
            $contactsCreated++;
        }

        $this->command->info("Created {$contactsCreated} contacts successfully!");
    }
}
