<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\items>
 */
class ItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_item' => 'IT-' . strtoupper(Str::random(5)),
            'nama_item' => $this->faker->words(2, true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
