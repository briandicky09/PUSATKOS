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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('kos_id')->constrained('kos')->onDelete('restrict');
            $table->string('booking_code', 50)->unique();
            $table->string('tenant_name', 100);
            $table->string('tenant_phone', 30);
            $table->string('tenant_email', 150);
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedTinyInteger('duration_months')->default(1);
            $table->decimal('kos_price', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('admin_fee', 12, 2)->default(25000.00);
            $table->decimal('total_amount', 12, 2);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'active', 'completed', 'cancelled', 'rejected'])->default('pending');
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
