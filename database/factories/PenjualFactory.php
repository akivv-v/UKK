<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penjual>
 */
class PenjualFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'password' => '$2y$12$J/w/rXk.hXG.w.2/3.1.5.j.5.4.3.2.1.0', // password
            'nama_user' => fake()->name(),
            'alamat' => fake()->address(),
            'no_hp' => fake()->numerify('08##########'),
            'role' => fake()->randomElement(['Admin', 'Pemilik Toko']),
        ];
    }
}
