<?php

namespace Database\Factories;

use App\Models\ProjectTechnology;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectTechnology>
 */
class ProjectTechnologyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTechnology::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'technologie' => $this->faker->unique()->sentence(1),
        ];
    }
}