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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('training_partner_profile_id')
                ->constrained('training_partner_profiles')
                ->cascadeOnDelete();

            $table->string('course_name', 200);

            $table->string('category', 150)->nullable();

            $table->text('description');

            $table->string('duration', 100);

            $table->decimal('fees', 10, 2)->default(0);

            $table->enum('training_mode', [
                'online',
                'offline',
                'hybrid',
            ]);

            $table->date('start_date')->nullable();

            $table->text('skills_covered')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
                'removed',
            ])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};