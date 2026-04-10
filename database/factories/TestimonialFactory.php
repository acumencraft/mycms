<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $testimonials = [
            "Archvadze delivered exactly what we needed. Their attention to detail and technical expertise helped us launch our e-commerce platform ahead of schedule. Highly recommended!",
            "Working with Archvadze was a game-changer for our business. They transformed our outdated website into a modern, user-friendly platform that increased our conversion rates significantly.",
            "The team's professionalism and communication throughout the project was outstanding. They delivered a high-quality website that exceeded our expectations.",
            "Archvadze's expertise in web development is unmatched. They helped us create a custom solution that perfectly fits our business needs and budget.",
            "From concept to launch, Archvadze guided us through every step of the process. The final product is beautiful, functional, and has been a great asset to our company.",
            "We were impressed by Archvadze's ability to understand our requirements and deliver a solution that not only met but exceeded our expectations.",
            "The website Archvadze built for us has been instrumental in growing our online presence. Their work is professional, timely, and of the highest quality.",
        ];

        return [
            'client_id' => Client::factory(),
            'client_name' => $this->faker->name(),
            'client_position' => $this->faker->jobTitle(),
            'company' => $this->faker->company(),
            'testimonial_text' => $this->faker->randomElement($testimonials),
            'rating' => $this->faker->numberBetween(4, 5), // 4-5 star ratings
            'is_featured' => $this->faker->boolean(40), // 40% chance of being featured
            'is_published' => $this->faker->boolean(90), // 90% chance of being published
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-1 week'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /**
     * Indicate that the testimonial is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the testimonial is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    /**
     * Indicate that the testimonial is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}