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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_enrollment_id')
                ->constrained('course_enrollments')
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->string('transaction_id', 255)
                ->nullable()
                ->unique();

            $table->enum('payment_status', [
                'pending',
                'success',
                'failed',
            ])->default('pending');

            $table->timestamp('payment_date')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};