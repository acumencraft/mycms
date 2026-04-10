<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'client_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'domain' => $this->faker->domainName(),
            'website_type' => $this->faker->randomElement(['business', 'e-commerce', 'portfolio', 'blog', 'landing-page']),
            'price_estimate' => $this->faker->numberBetween(1000, 50000),
            'status' => $this->faker->randomElement(['pending', 'contacted', 'accepted', 'rejected']),
        ];
    }
}