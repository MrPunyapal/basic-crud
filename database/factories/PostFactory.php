<?php

namespace Database\Factories;

use App\Enums\FeaturedStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'title' => $this->faker->words(5, true),
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(),
            'body' => $this->faker->randomHtml(),
            'published_at' => $this->faker->dateTimeBetween('-1 month', '+3 months'),
            'category' => $this->faker->numberBetween(0, 7),
            'tags' => $this->faker->randomElements(['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications'], $this->faker->numberBetween(1, 3)),
            'is_featured' => $this->faker->randomElement(array_column(FeaturedStatus::cases(), 'value')),
        ];
    }
}
