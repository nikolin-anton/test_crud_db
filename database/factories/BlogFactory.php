<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $is_published = rand(0, 1);

        return [
            'title' => $this->faker->sentence(rand(3, 8), true),
            'content' => $this->faker->realText(rand(1000, 4000)),
            'is_published' => $is_published,
            'published_at' => $is_published === 1
                ? $this->faker->dateTimeBetween('-1 week', '+1 week') : null,
        ];
    }
}
