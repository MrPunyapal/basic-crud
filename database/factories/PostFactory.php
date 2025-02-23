<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\FeaturedStatus;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function definition(): array
    {

        return [
            'title' => $this->faker->words(5, true),
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'image' => $this->fakeImageUrl(),
            'content' => $this->faker->randomHtml(),
            'published_at' => $this->faker->dateTimeBetween('-1 month', '+3 months'),
            'category_id' => CategoryFactory::new(),
            'tags' => $this->faker->randomElements(['Eloquent', 'Blade', 'Migrations', 'Seeding', 'Routing', 'Controllers', 'Middleware', 'Requests', 'Responses', 'Views', 'Forms', 'Validation', 'Mail', 'Notifications'], $this->faker->numberBetween(1, 3)),
            'is_featured' => $this->faker->randomElement(array_column(FeaturedStatus::cases(), 'value')),
        ];
    }

    /**
     * Generate a fake image URL.
     */
    private function fakeImageUrl(): string
    {
        return 'https://fakeimg.pl/350x200/?text='.$this->faker->word;
    }
}
