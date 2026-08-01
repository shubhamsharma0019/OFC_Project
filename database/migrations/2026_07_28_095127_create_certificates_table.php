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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fresher_profile_id')
                ->constrained('fresher_profiles')
                ->cascadeOnDelete();

            $table->foreignId('course_enrollment_id')
                ->unique()
                ->constrained('course_enrollments')
                ->cascadeOnDelete();

            $table->foreignId('final_assessment_result_id')
                ->unique()
                ->constrained('assessment_results')
                ->cascadeOnDelete();

            $table->string('certificate_number', 100)
                ->unique();

            $table->string('certificate_file');

            $table->date('completion_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};