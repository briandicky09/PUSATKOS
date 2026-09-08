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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('restrict');
            $table->foreignId('customer_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('kos_id')->constrained('kos')->onDelete('restrict');
            $table->string('invoice_number', 50)->unique();
            $table->decimal('amount', 12, 2);
            $table->decimal('admin_fee', 12, 2)->default(25000.00);
            $table->decimal('tax', 12, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2);
            $table->date('due_date');
            $table->timestamp('paid_at')->nullable();
            $table->enum('status', ['unpaid', 'paid', 'expired', 'cancelled'])->default('unpaid');
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index(['kos_id', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
