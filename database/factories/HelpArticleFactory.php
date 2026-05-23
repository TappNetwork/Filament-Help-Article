<?php

namespace Tapp\FilamentHelp\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tapp\FilamentHelp\Models\HelpArticle;
use Tapp\FilamentHelp\Support\Tenancy;

/**
 * @extends Factory<HelpArticle>
 */
class HelpArticleFactory extends Factory
{
    protected $model = HelpArticle::class;

    public function definition(): array
    {
        $definition = [
            'name' => $this->faker->sentence(3),
            'is_public' => $this->faker->boolean(70), // 70% chance of being public
            'content' => $this->faker->paragraphs(3, true),
        ];

        // Add tenant column if tenancy is enabled
        if (Tenancy::hasTenantColumn()) {
            $definition[Tenancy::column()] = null; // Will be set explicitly or by model boot logic
        }

        return $definition;
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

    public function hidden(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_hidden' => true,
        ]);
    }

    public function forTeam($team): static
    {
        if (! Tenancy::hasTenantColumn()) {
            return $this;
        }

        return $this->state(fn (array $attributes) => [
            Tenancy::column() => is_object($team) ? $team->id : $team,
        ]);
    }
}
