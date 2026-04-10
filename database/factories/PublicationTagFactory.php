<?php

namespace Database\Factories;

use App\Models\PublicationTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublicationTag>
 */
class PublicationTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PublicationTag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = [
            'Laravel',
            'PHP',
            'JavaScript',
            'React',
            'Vue.js',
            'SEO',
            'WordPress',
            'E-commerce',
            'Mobile Apps',
            'Web Design',
            'Digital Marketing',
            'API',
            'Database',
            'Frontend',
            'Backend',
            'DevOps',
            'UI/UX',
            'Performance',
            'Security',
            'Analytics',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($tags),
            'slug' => $this->faker->unique()->slug(1, 3),
        ];
    }

}