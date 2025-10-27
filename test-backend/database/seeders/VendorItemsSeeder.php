<?php

namespace Database\Seeders;

use App\Models\VendorItems;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VendorItems::factory()->count(100)->create();
    }
}
