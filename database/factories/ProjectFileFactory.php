<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectFile>
 */
class ProjectFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectFile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileTypes = [
            'Design Files' => ['design-mockup.psd', 'wireframes.pdf', 'style-guide.pdf'],
            'Documents' => ['project-brief.pdf', 'requirements.docx', 'contract.pdf'],
            'Images' => ['logo.png', 'banner.jpg', 'favicon.ico'],
            'Code Files' => ['source-code.zip', 'database-schema.sql', 'api-documentation.pdf'],
            'Reports' => ['progress-report.pdf', 'testing-results.pdf', 'final-report.pdf'],
        ];

        $category = $this->faker->randomElement(array_keys($fileTypes));
        $fileName = $this->faker->randomElement($fileTypes[$category]);

        return [
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
            'file_name' => $fileName,
            'file_path' => 'project-files/' . $this->faker->uuid() . '/' . $fileName,
            'file_size' => $this->faker->numberBetween(1024, 10485760), // 1KB to 10MB
            'file_type' => $this->faker->randomElement(['pdf', 'docx', 'jpg', 'png', 'zip', 'psd', 'sql']),
            'category' => $category,
            'description' => $this->faker->optional(0.7)->sentence(8, 15),
            'is_public' => $this->faker->boolean(30), // 30% chance of being public
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }

    /**
     * Indicate that the file is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }

    /**
     * Indicate that the file is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => false,
        ]);
    }
}