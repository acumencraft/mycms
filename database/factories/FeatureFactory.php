<?php

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feature>
 */
class FeatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feature::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $features = [
            'Responsive Design' => 'Mobile-first responsive website design',
            'Contact Forms' => 'Custom contact forms with validation',
            'Social Media Integration' => 'Social media links and sharing buttons',
            'Google Analytics' => 'Website analytics and tracking setup',
            'SSL Certificate' => 'HTTPS security certificate installation',
            'SEO Optimization' => 'Basic search engine optimization',
            'Admin Panel' => 'Content management system for clients',
            'Payment Integration' => 'Payment gateway setup for e-commerce',
            'Multi-language Support' => 'Website translation and localization',
            'Performance Optimization' => 'Website speed and performance improvements',
        ];

        $featureName = $this->faker->randomElement(array_keys($features));

        return [
            'name' => $featureName,
            'description' => $features[$featureName],
            'price' => $this->faker->numberBetween(100, 2000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

}