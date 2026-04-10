<?php

namespace Database\Factories;

use App\Models\Guide;
use App\Models\GuideCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideFactory extends Factory
{
    protected $model = Guide::class;

    public function definition(): array
    {
        $titles = [
            'Getting Started with Web Development',
            'SEO Best Practices for Small Businesses',
            'Choosing the Right Web Hosting Provider',
            'Mobile-First Design Principles',
            'WordPress Security Essentials',
            'E-commerce Platform Comparison',
            'Social Media Integration Guide',
            'Website Performance Optimization',
            'Content Management System Selection',
            'Digital Marketing Strategy Basics',
        ];

        return [
            'guide_category_id' => GuideCategory::factory(),
            'title' => $this->faker->unique()->randomElement($titles),
            'slug' => $this->faker->unique()->slug(3),
            'content' => $this->faker->paragraphs(10, true),
            'published_at' => $this->faker->optional(0.8)->dateTimeBetween('-2 months', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-4 months', '-1 week'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
