<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_produk' => fake()->words(3, true),
            'harga' => fake()->numberBetween(10000, 1000000), // 10k to 1jt
            'stok' => fake()->numberBetween(1, 100),
            'foto_produk' => null, // Placeholder or null
        ];
    }
}
