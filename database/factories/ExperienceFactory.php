<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Experience::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-5 years', '-2 years');
        $endDate = $this->faker->randomElement([null, $this->faker->dateTimeBetween($startDate, 'now')]);

        return [
            'title' => $this->faker->jobTitle,
            'company' => $this->faker->company,
            'location' => $this->faker->city,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
            'description' => $this->faker->paragraph,
        ];
    }
}