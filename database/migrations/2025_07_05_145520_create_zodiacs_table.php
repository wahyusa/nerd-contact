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
        Schema::create('zodiacs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Aries, Taurus, etc.
            $table->string('symbol'); // ♈, ♉, etc.
            $table->string('element'); // Fire, Earth, Air, Water
            $table->date('start_date'); // e.g., 2024-03-21 (March 21)
            $table->date('end_date'); // e.g., 2024-04-19 (April 19)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zodiacs');
    }
};
