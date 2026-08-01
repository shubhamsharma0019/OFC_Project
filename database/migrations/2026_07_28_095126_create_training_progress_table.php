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
        Schema::create('training_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_enrollment_id')
                ->unique()
                ->constrained('course_enrollments')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('progress_percentage')
                ->default(0);

            $table->enum('current_status', [
                'not_started',
                'in_progress',
                'completed',
            ])->default('not_started');

            $table->string('short_remark', 500)
                ->nullable();

            $table->date('completion_date')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_progress');
    }
};