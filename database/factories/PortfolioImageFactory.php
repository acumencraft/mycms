<?php

namespace Database\Factories;

use App\Models\PortfolioImage;
use App\Models\PortfolioProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PortfolioImage>
 */
class PortfolioImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PortfolioImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageTypes = ['screenshot', 'mockup', 'design', 'mobile', 'desktop'];
        $altTexts = [
            'Website homepage design',
            'Mobile responsive layout',
            'E-commerce product page',
            'Dashboard interface',
            'Landing page design',
            'Portfolio showcase',
            'Admin panel screenshot',
            'User interface mockup',
        ];

        return [
            'portfolio_project_id' => PortfolioProject::factory(),
            'image_path' => 'portfolio-images/' . $this->faker->uuid() . '.jpg',
            'image_type' => $this->faker->randomElement($imageTypes),
            'alt_text' => $this->faker->randomElement($altTexts),
            'sort_order' => $this->faker->numberBetween(1, 10),
            'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /**
     * Indicate that the image is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the image is not featured.
     */
    public function notFeatured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => false,
        ]);
    }
}