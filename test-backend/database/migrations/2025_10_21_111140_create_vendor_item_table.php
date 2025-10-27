<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_item', function (Blueprint $table) {
            $table->id('id_vendor_item');
            $table->foreignId('id_vendor')->constrained('vendors', 'id_vendor');
            $table->foreignId('id_item')->constrained('items', 'id_item');
            $table->decimal('harga_sebelumnya', 15, 2)->default(0);
            $table->decimal('harga_sekarang', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_item');
    }
};
