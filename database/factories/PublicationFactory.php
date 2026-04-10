<?php

namespace Database\Factories;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Publication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6, 12);

        return [
            'title' => $title,
            'slug' => $this->faker->unique()->slug(3, 8),
            'content' => $this->faker->paragraphs(8, true),
            'excerpt' => $this->faker->paragraph(),
            'author_id' => User::factory(),
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'is_published' => $this->faker->boolean(80), // 80% chance of being published
            'published_at' => $this->faker->optional(0.8)->dateTimeBetween('-3 months', 'now'), // 80% have published_at
            'created_at' => $this->faker->dateTimeBetween('-6 months', '-1 week'),
            'updated_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    /**
     * Indicate that the publication is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ]);
    }

    /**
     * Indicate that the publication is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}