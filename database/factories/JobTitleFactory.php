<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobTitle>
 */
class JobTitleFactory extends Factory
{
    public static $jobTitles = [
        'Teknik Rekayasa Perangkat Lunak',
        'teknik Informatika',
        'Teknik Komputer',
        'Teknik Elektro',
        'Teknik Mesin',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(self::$jobTitles),
        ];
    }
}
