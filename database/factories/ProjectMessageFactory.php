<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectMessageFactory extends Factory
{
    protected $model = ProjectMessage::class;

    public function definition(): array
    {
        $messages = [
            "I've started working on the initial design concepts for your website.",
            "The development phase is now underway. I'll keep you updated on progress.",
            "I've completed the first draft of the homepage. Would you like to review it?",
            "We're making good progress on the backend functionality.",
            "The mobile responsiveness has been optimized.",
            "All features have been implemented and tested.",
        ];

        return [
            'project_id' => Project::factory(),
            'sender_id' => User::factory(),
            'message' => $this->faker->randomElement($messages),
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
