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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')
                ->constrained('jobs')
                ->cascadeOnDelete();

            $table->foreignId('fresher_profile_id')
                ->constrained('fresher_profiles')
                ->cascadeOnDelete();

            $table->enum('application_status', [
                'applied',
                'under_review',
                'shortlisted',
                'interview_scheduled',
                'hired',
                'rejected',
            ])->default('applied');

            $table->timestamp('applied_at')
                ->useCurrent();

            $table->timestamps();

            $table->unique([
                'job_id',
                'fresher_profile_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};