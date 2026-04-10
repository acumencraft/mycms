<?php

namespace Database\Factories;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Poll::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $questions = [
            "What's your biggest challenge with your current website?",
            "Which web technology are you most interested in learning?",
            "How important is mobile responsiveness for your business?",
            "What's your preferred project timeline for web development?",
            "Which feature would you most like to add to your website?",
        ];

        return [
            'question' => $this->faker->randomElement($questions),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

}