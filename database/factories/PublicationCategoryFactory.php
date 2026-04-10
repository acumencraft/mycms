<?php

namespace Database\Factories;

use App\Models\PublicationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublicationCategory>
 */
class PublicationCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PublicationCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Web Development',
            'Digital Marketing',
            'UI/UX Design',
            'Technology Trends',
            'Business Tips',
            'Case Studies',
            'Tutorials',
            'Industry News',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'slug' => $this->faker->unique()->slug(2, 4),
        ];
    }

}