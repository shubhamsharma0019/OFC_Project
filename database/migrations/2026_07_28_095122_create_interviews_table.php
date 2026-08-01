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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_application_id')
                ->unique()
                ->constrained('job_applications')
                ->cascadeOnDelete();

            $table->date('interview_date');

            $table->time('interview_time');

            $table->enum('interview_mode', [
                'online',
                'offline',
            ]);

            $table->string('interview_location', 255)
                ->nullable();

            $table->string('meeting_link', 500)
                ->nullable();

            $table->enum('status', [
                'scheduled',
                'completed',
                'cancelled',
            ])->default('scheduled');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};