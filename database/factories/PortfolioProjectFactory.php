<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\PortfolioProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PortfolioProject>
 */
class PortfolioProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PortfolioProject::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectTypes = ['website', 'e-commerce', 'web-app', 'mobile-app', 'branding'];
        $technologies = [
            'Laravel, Vue.js, MySQL',
            'WordPress, PHP, JavaScript',
            'React, Node.js, MongoDB',
            'Django, PostgreSQL, Redis',
            'Next.js, TypeScript, GraphQL',
            'Symfony, MySQL, jQuery',
            'Express.js, React, SQLite',
            'Ruby on Rails, PostgreSQL, Bootstrap',
        ];

        return [
            'client_id' => Client::factory(),
            'title' => $this->faker->sentence(3, 8),
            'slug' => $this->faker->unique()->slug(3, 8),
            'description' => $this->faker->paragraphs(3, true),
            'project_url' => $this->faker->url(),
            'technologies' => $this->faker->randomElement($technologies),
            'project_type' => $this->faker->randomElement($projectTypes),
            'is_featured' => $this->faker->boolean(30), // 30% chance of being featured
            'is_published' => $this->faker->boolean(90), // 90% chance of being published
            'completed_at' => $this->faker->dateTimeBetween('-2 years', '-1 month'),
            'created_at' => $this->faker->dateTimeBetween('-2 years', '-1 month'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that the portfolio project is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the portfolio project is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    /**
     * Indicate that the portfolio project is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}