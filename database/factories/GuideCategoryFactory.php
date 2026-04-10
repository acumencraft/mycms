<?php

namespace Database\Factories;

use App\Models\GuideCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuideCategory>
 */
class GuideCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GuideCategory::class;

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
            'Design & UX',
            'E-commerce',
            'WordPress',
            'SEO & Analytics',
            'Security',
            'Business Tools',
            'Mobile Development',
            'Content Strategy',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'slug' => $this->faker->unique()->slug(2, 4),
        ];
    }

}