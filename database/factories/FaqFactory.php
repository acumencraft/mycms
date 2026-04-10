<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $questions = [
            'What services do you offer?' => 'We offer web development, design, SEO, and more.',
            'How much do your services cost?' => 'Pricing depends on the project. Contact us for a quote.',
            'How long does a project take?' => 'Timelines vary from 1-6 months depending on complexity.',
            'Do you provide maintenance?' => 'Yes, we offer ongoing maintenance and support packages.',
            'What technologies do you use?' => 'We use Laravel, React, Vue.js, and other modern technologies.',
            'Can I see examples of your work?' => 'Yes, check out our portfolio section.',
            'Do you work with international clients?' => 'Absolutely, we work with clients worldwide.',
            'What is your payment process?' => 'We require 50% upfront and 50% upon completion.',
            'Do you offer refunds?' => 'Refunds are handled on a case-by-case basis.',
            'How can I contact you?' => 'You can contact us via email, phone, or our contact form.',
        ];

        $question = $this->faker->unique()->randomElement(array_keys($questions));

        return [
            'category_id' => FaqCategory::factory(),
            'question' => $question,
            'answer' => $questions[$question],
        ];
    }
}