<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-3 years', 'now');
        $endDate = $this->faker->randomElement([null, $this->faker->dateTimeBetween($startDate, 'now')]);

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'image' => 'https://via.placeholder.com/640x480.png/' . $this->faker->hexColor() . '?text=' . $this->faker->word(),
        ];
    }
}