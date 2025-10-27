<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tgl_order' => $this->faker->date('Y-m-d'),
            'no_order' => 'ORD-' . strtoupper(Str::random(8)),
            'total_order' => $this->faker->numberBetween(10000, 500000),
            'status_order' => $this->faker->randomElement(['pending', 'process', 'done', 'cancel']),
            'id_user' => User::inRandomOrder()->value('id'),
        ];
    }
}
