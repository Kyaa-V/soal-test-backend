<?php

namespace Database\Factories;

use App\Models\Items;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendorItems>
 */
class VendoritemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_vendor' => Vendor::inRandomOrder()->value('id_vendor'),
            'id_item' => Items::inRandomOrder()->value('id_item'),
            'harga_sebelumnya' => $this->faker->randomFloat(2, 1000, 10000),
            'harga_sekarang' => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}
