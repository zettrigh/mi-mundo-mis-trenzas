<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::title(fake()->words(2, true));

        return [
            'name' => $name,
            // Sufijo aleatorio en el slug: unique() de Faker persiste entre
            // pruebas y agota el generador; el azar aquí basta.
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(8)),
            'category' => fake()->randomElement(['Tradicionales', 'Modernas', 'Personalizadas']),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 20, 120),
            'estimated_duration_minutes' => fake()->randomElement([90, 120, 180, 240]),
            'image_url' => 'https://placehold.co/200x200?text='.str_replace(' ', '+', $name),
            'includes_extensions' => fake()->boolean(),
            'is_active' => true,
        ];
    }

    /**
     * Servicio desactivado del catálogo (oculto para las clientes).
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
