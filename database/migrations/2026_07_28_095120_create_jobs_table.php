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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_profile_id')
                ->constrained('company_profiles')
                ->cascadeOnDelete();

            $table->string('title', 200);

            $table->text('description');

            $table->text('required_skills')->nullable();

            $table->string('qualification', 200)->nullable();

            $table->string('location', 200)->nullable();

            $table->string('salary', 100)->nullable();

            $table->string('job_type', 50)->nullable();

            $table->unsignedInteger('openings')->default(1);

            $table->enum('hiring_mode', [
                'direct',
                'fast_track',
            ])->default('direct');

            $table->date('application_last_date')->nullable();

            $table->enum('status', [
                'draft',
                'active',
                'inactive',
                'removed',
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};