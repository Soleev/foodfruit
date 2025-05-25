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
        Schema::create('discount_tier_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_tier_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('threshold_amount', 15, 2);
            $table->decimal('discount_percentage', 5, 2);
            $table->string('action'); // Тип действия: 'created', 'updated', 'deleted'
            $table->timestamp('action_at'); // Время действия
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_tier_history');
    }
};
