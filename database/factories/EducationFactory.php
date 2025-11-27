<?php

namespace Database\Factories;

use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Education::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-10 years', '-5 years');
        $endDate = $this->faker->dateTimeBetween($startDate, 'now');

        return [
            'degree' => $this->faker->randomElement(['Bachelor', 'Master', 'PhD', 'Associate']),
            'school' => $this->faker->company,
            'field_of_study' => $this->faker->jobTitle,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'description' => $this->faker->paragraph,
        ];
    }
}