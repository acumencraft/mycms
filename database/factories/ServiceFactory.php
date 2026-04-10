<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            'Web Development' => 'Custom website development using modern technologies',
            'E-commerce Solutions' => 'Complete online store setup and integration',
            'Mobile App Development' => 'Native and cross-platform mobile applications',
            'SEO Optimization' => 'Search engine optimization and digital marketing',
            'UI/UX Design' => 'User interface and experience design services',
            'Content Management' => 'CMS setup and content strategy',
            'API Development' => 'RESTful API design and implementation',
            'Maintenance & Support' => 'Ongoing website maintenance and technical support',
        ];

        $serviceName = $this->faker->randomElement(array_keys($services));

        return [
            'name' => $serviceName,
            'description' => $services[$serviceName] . '. ' . $this->faker->paragraph(),
            'base_price' => $this->faker->numberBetween(1000, 15000),
            'status' => $this->faker->boolean(90), // 90% chance of being active
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /**
     * Indicate that the service is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the service is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}