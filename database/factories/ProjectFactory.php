<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'in_progress', 'review', 'completed']);

        return [
            'client_id' => Client::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(2, true),
            'status' => $status,
            'price' => $this->faker->numberBetween(1000, 50000),
            'deadline' => $this->faker->dateTimeBetween('now', '+6 months'),
            'created_at' => $this->faker->dateTimeBetween('-6 months', '-1 week'),
            'updated_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
