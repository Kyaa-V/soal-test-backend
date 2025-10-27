<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class VendorFactory extends Factory
{
    private static $vendorCount = 0;

    public function definition(): array
    {
        self::$vendorCount++;

        return [
            'kode_vendor' => 'VND' . str_pad(self::$vendorCount, 2, '0', STR_PAD_LEFT),
            'nama_vendor' => $this->faker->company() . ' Vendor', // Lebih realistic
            'id_user'     => User::factory(), // Auto create user
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}