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
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fresher_profile_id')
                ->constrained('fresher_profiles')
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->timestamp('enrollment_date')
                ->useCurrent();

            $table->enum('enrollment_status', [
                'pending',
                'enrolled',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
            ])->default('pending');

            $table->enum('training_status', [
                'not_started',
                'in_progress',
                'completed',
            ])->default('not_started');

            $table->timestamps();

            $table->unique([
                'fresher_profile_id',
                'course_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
    }
};