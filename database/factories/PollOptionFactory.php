<?php

namespace Database\Factories;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PollOption>
 */
class PollOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PollOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $options = [
            // Website challenges
            'Slow loading speed',
            'Outdated design',
            'Poor mobile experience',
            'Lack of functionality',
            'Security concerns',
            // Technologies
            'React/Vue.js',
            'Laravel/Django',
            'WordPress',
            'Mobile app development',
            'AI/ML integration',
            // Mobile responsiveness
            'Very important',
            'Somewhat important',
            'Not very important',
            'Not important at all',
            // Timeline
            'ASAP (1-2 weeks)',
            '1-3 months',
            '3-6 months',
            '6+ months',
            // Features
            'E-commerce functionality',
            'Blog/Content management',
            'User login system',
            'Contact forms',
            'Social media integration',
        ];

        return [
            'poll_id' => Poll::factory(),
            'option_text' => $this->faker->randomElement($options),
            'votes_count' => $this->faker->numberBetween(0, 50),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }
}