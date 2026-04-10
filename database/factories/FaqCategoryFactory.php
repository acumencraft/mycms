<?php

namespace Database\Factories;

use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqCategoryFactory extends Factory
{
    protected $model = FaqCategory::class;

    public function definition(): array
    {
        $categories = ['General', 'Services', 'Pricing', 'Technical', 'Support'];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
