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
        Schema::create('kos_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kos_id')
                ->constrained('kos')
                ->cascadeOnDelete();
            $table->string('photo_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['kos_id', 'photo_path']);
            $table->index(['kos_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kos_photos');
    }
};
