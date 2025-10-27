<?php

namespace Database\Factories;

use App\Models\Items;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_order' => Order::inRandomOrder()->value('id_order'),
            'id_item' => Items::inRandomOrder()->value('id_item'),
            'jumlah_item' => $this->faker->numberBetween(1, 10),
            'harga_item' => $this->faker->numberBetween(1000, 100000),  
        ];
    }
}
