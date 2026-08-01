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
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attempt_id')
                ->unique()
                ->constrained('assessment_attempts')
                ->cascadeOnDelete();

            $table->decimal('technical_score', 5, 2)
                ->default(0);

            $table->decimal('aptitude_score', 5, 2)
                ->default(0);

            $table->decimal('communication_score', 5, 2)
                ->default(0);

            $table->decimal('overall_score', 5, 2)
                ->default(0);

            $table->string('recommended_track', 200)
                ->nullable();

            $table->enum('result', [
                'completed',
                'pass',
                'fail',
            ])->default('completed');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};