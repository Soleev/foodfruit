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
        Schema::create('discount_tiers', function (Blueprint $table) {
            $table->id();
            $table->decimal('threshold_amount', 15, 2); // Пороговая сумма (например, 10000000.00)
            $table->decimal('discount_percentage', 5, 2); // Процент скидки (например, 10.00)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_tiers');
    }
};
