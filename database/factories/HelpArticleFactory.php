<?php

namespace Tapp\FilamentHelp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tapp\FilamentHelp\Models\HelpArticle;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Tapp\FilamentHelp\Models\HelpArticle>
 */
class HelpArticleFactory extends Factory
{
    protected $model = HelpArticle::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'is_public' => $this->faker->boolean(70), // 70% chance of being public
            'content' => $this->faker->paragraphs(3, true),
        ];
    }

    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }

    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => false,
        ]);
    }
}
